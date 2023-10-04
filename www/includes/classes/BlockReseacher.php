<?php

class BlockReseacher extends ABlock
{
    protected string $_sections = RString::EMPTY;

    public function __construct(string $id = RString::EMPTY, string $classes = RString::EMPTY)
    {
        parent::__construct($id, $classes);
    }

    public function searchSection(): void
    {
        $value = isset($_GET['searchFor']) ? 'value="' . $_GET['searchFor'] . '"' : RString::EMPTY;
        $this->_sections .= '<input type="text" ' . $value . ' onkeyup="setURLParam(\'searchFor\', value)"/>';
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
        $dynInputs[] = $field;

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
        return '<div id="' . $slug . 'DynInput" class="dynInput"><input id="' . $slug . 'Field" type="text" name="' . $inputName . '" value="' . $value . '" readonly><button type="button" onclick="DynDataRemove(\'' . $slug . 'DynInput\')">x</button></div>';
    }

    /**
     * @inheritDoc
     */
    public function display(): string
    {
        return '<div ' . $this->getSignature() . '>' . $this->_sections . '</div>';
    }
}