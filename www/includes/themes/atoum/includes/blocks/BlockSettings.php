<?php

class BlockSettings extends ABlock
{
    protected AContent $_content;
    protected string $_sections = RString::EMPTY;
    protected array $_dynInputs;

    public function __construct(EDataType $type, int $contentId, string $id = RString::EMPTY, string $classes = RString::EMPTY)
    {
        parent::__construct($id, $classes);
        $this->_content = AContent::createInstance($type, $contentId);
    }

    public function nameSection(): void
    {
        $name = $this->_content->getId() == null ? RString::EMPTY : 'value="' . $this->_content->getName() . '"';
        $this->_sections .= '<label for="name">Name </label><input type="text" name="name"' . $name . ' required />';
    }

    public function dateCreated(): void
    {
        $date = $this->_content->getId() == null ? RString::EMPTY : 'value="' . $this->_content->getDateCreated()->format(FileHandler::DATE_FORMAT_LONG) . '"';
        $this->_sections .= '<label for="dateCreated">Date created </label><input type="datetime-local" id="dateCreated" name="dateCreated"' . $date . ' disabled />';
    }

    public function dateModified(): void
    {
        $date = $this->_content->getId() == null ? RString::EMPTY : 'value="' . $this->_content->getDateModified()->format(FileHandler::DATE_FORMAT_LONG) . '"';
        $this->_sections .= '<label for="dateModified">Date created </label><input type="datetime-local" id="dateModified" name="dateModified"' . $date . ' disabled />';
    }

    /**
     * Crée le nécessaire pour rechercher, ajouter et supprimer des éléments dynamiquement.
     * @param string $fieldName
     * @param EDataType $typeB
     * @return void
     * @throws Exception
     */
    public function liveSection(string $title, EDataType $typeB): void
    {
        $in = RString::EMPTY;
        $fieldName = strtolower($typeB->name);
        $field = $fieldName . '[]';
        $this->_dynInputs[] = $field;

        foreach (Relation::getChildren(Relation::getRelationType($typeB, $this->_content->getType()), $this->_content->getId()) as $sub) {
            $in .= $this->createLiveInput($sub->getName(), $field);
        }

        $this->_sections .= '<h4>' . $title . '</h4>';

        $this->_sections .= '<div id="' . $fieldName . 'DynDataInputs" class="dynDataSearch inputs';
        $this->_sections .= $in == RString::EMPTY ? ' empty' : RString::EMPTY;
        $this->_sections .= '">' . $in . '</div>';

        $this->_sections .= '<input type="text" onkeyup="DynDataSearch(this, ' . $typeB->value . ', \'' . $fieldName . '\')" onkeydown="DynDataAddOnHit(this.value, ' . $typeB->value . ', \'' . $field . '\')">';

        $this->_sections .= '<div id="' . $fieldName . 'DynDataResults" class="dynDataSearch results empty"></div>';
    }

    private function createLiveInput(string $value, string $inputName): string
    {
        $slug = normalize($value);
        return '<div id="' . $slug . 'DynInput" class="dynInput"><input id="' . $slug . 'Field" type="text" name="' . $inputName . '" value="' . $value . '"><button type="button" onclick="DynDataRemove(\'' . $slug . 'DynInput\')">x</button></div>';
    }

    /**
     * @inheritDoc
     */
    public function display(bool $echo = true): string
    {
        $r = '<div ' . $this->getSignature() . '><form id="DynDataForm' . $this->_content->getId() . '">' . $this->_sections . '<button type="button" onclick="DynDataSubmit(\'DynDataForm\', ' . $this->_content->getId() . ', ' . $this->_content->getType()->value . ', [\'' . RString::join('\',\'', $this->_dynInputs) . '\'])">Save</button></form></div>';

        if ($echo) {
            echo $r;
            return RString::EMPTY;
        }

        return $r;
    }
}