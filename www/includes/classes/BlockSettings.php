<?php

class BlockSettings extends ABlock
{
    protected AContent $_content;
    protected string $_sections = RString::EMPTY;
    protected array $_dynInputs;

    public function __construct(EDataType $type, int $contentId, string $id = RString::EMPTY, string $classes = RString::EMPTY)
    {
        parent::__construct($id, $classes);
        RString::concat($this->_classes, RString::SPACE, 'settings');
        $this->_content = AContent::createInstance($type, $contentId);
    }


    /**
     * Même formulaire de modification pour tous les types de données.
     * @param AContent $data
     * @return BlockSettings
     * @throws Exception
     */
    public static function base(AContent $data): BlockSettings
    {
        $settings = new BlockSettings($data->getType(), $data->getId());
        $settings->nameSection();
        $settings->dateCreated();
        $settings->dateModified();
        $settings->DynamicData('Actors', EDataType::ACTOR);
        $settings->DynamicData('Tags', EDataType::TAG);
        return $settings;
    }

    public function nameSection(): void
    {
        $name = $this->_content->getId() == null ? RString::EMPTY : 'value="' . $this->_content->getName() . '"';
        $this->_sections .= '<div><label for="name">Name </label><input type="text" name="name"' . $name . ' required /></div>';
    }

    public function dateCreated(): void
    {
        $date = $this->_content->getId() == null ? RString::EMPTY : 'value="' . $this->_content->getDateCreated()->format(FileHandler::DATE_FORMAT_LONG) . '"';
        $this->_sections .= '<div><label for="dateCreated">Date created </label><input type="datetime-local" id="dateCreated" name="dateCreated"' . $date . ' disabled /></div>';
    }

    public function dateModified(): void
    {
        $date = $this->_content->getId() == null ? RString::EMPTY : 'value="' . $this->_content->getDateModified()->format(FileHandler::DATE_FORMAT_LONG) . '"';
        $this->_sections .= '<div><label for="dateModified">Date modified </label><input type="datetime-local" id="dateModified" name="dateModified"' . $date . ' disabled /></div>';
    }

    /**
     * Crée le nécessaire pour rechercher, ajouter et supprimer des éléments dynamiquement.
     * @param string $title
     * @param EDataType $typeB
     * @return void
     * @throws Exception
     */
    public function DynamicData(string $title, EDataType $typeB): void
    {
        $in = RString::EMPTY;
        $fieldName = strtolower($typeB->name);
        $field = $fieldName . '[]';
        $this->_dynInputs[] = $field;

        foreach (Relation::getChildren(Relation::getRelationType($typeB, $this->_content->getType()), $this->_content->getId()) as $sub) {
            $in .= $this->createChip($sub->getName(), $field);
        }

        $this->_sections .= '<div><h4>' . $title . '</h4><div class="dynInputContainer">';

        $this->_sections .= '<div id="' . $fieldName . 'DynDataInputs" class="dynDataSearch chips';
        $this->_sections .= $in == RString::EMPTY ? ' empty' : RString::EMPTY;
        $this->_sections .= '">' . $in . '</div>';

        $this->_sections .= '<input type="text" onkeyup="DynDataSearch(this, ' . $typeB->value . ', \'' . $fieldName . '\')" onkeydown="DynDataAddOnHit(this.value, ' . $typeB->value . ', \'' . $field . '\')">';

        $this->_sections .= '<div id="' . $fieldName . 'DynDataResults" class="dynDataSearch results empty"></div></div></div>';
    }

    private function createChip(string $value, string $inputName): string
    {
        $slug = normalize($value);
        return '<div id="' . $slug . 'DynInput" class="chip edit">
                    <input id="' . $slug . 'Field" type="text" name="' . $inputName . '" value="' . $value . '" readonly>
                    <button type="button" onclick="DynDataEdit()"><i class="fa fa-edit"></i></button>
                    <button type="button" onclick="DynDataRemove(\'' . $slug . 'DynInput\')"><i class="fa fa-remove"></i></button>
                </div>';
    }

    /**
     * Réservé aux vidéos
     * @return void
     */
    public function screenshotButton(): void
    {
        if ($this->_content->getType() == EDataType::VIDEO) {
            $this->_sections .= '<button type="button" onclick="takeScreenshot(\'' . $this->_content->getSlug() . '\', ' . $this->_content->getId() . ')">Capture</button>';
            $this->_sections .= '<canvas id="' . $this->_content->getSlug() . 'Canvas" class="screenCanvas"></canvas>';
        }
    }

    /**
     * @inheritDoc
     */
    public function display(): string
    {
        return '<div ' . $this->getSignature() . '>
        <form id="DynDataForm' . $this->_content->getId() . '">' . $this->_sections . '
        <button type="button" onclick="DynDataSubmit(\'DynDataForm\', ' . $this->_content->getId() . ', ' . $this->_content->getType()->value . ', [\'' . RString::join('\',\'', $this->_dynInputs) . '\'])">Save</button>
        </form>
        </div>';
    }
}