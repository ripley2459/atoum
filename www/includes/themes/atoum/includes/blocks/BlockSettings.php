<?php

class BlockSettings extends ABlock
{
    protected AContent $_content;
    protected string $_sections = RString::EMPTY;

    public function __construct(EDataType $type, int $contentId, string $id = RString::EMPTY, string $classes = RString::EMPTY)
    {
        parent::__construct($id, $classes);
        $this->_content = AContent::createInstance($type, $contentId);
    }

    public function nameSection()
    {
        $name = $this->_content->getId() == null ? RString::EMPTY : 'value="' . $this->_content->getName() . '"';
        $this->_sections .= '<label for="name">Name </label><input type="text" name="name"' . $name . ' required />';
    }

    public function dateCreated()
    {
        $date = $this->_content->getId() == null ? RString::EMPTY : 'value="' . $this->_content->getDateCreated()->format(FileHandler::DATE_FORMAT_LONG) . '"';
        $this->_sections .= '<label for="dateCreated">Date created </label><input type="datetime-local" id="dateCreated" name="dateCreated"' . $date . ' disabled />';
    }

    public function dateModified()
    {
        $date = $this->_content->getId() == null ? RString::EMPTY : 'value="' . $this->_content->getDateModified()->format(FileHandler::DATE_FORMAT_LONG) . '"';
        $this->_sections .= '<label for="dateModified">Date created </label><input type="datetime-local" id="dateModified" name="dateModified"' . $date . ' disabled />';
    }

    protected function getActorCheckbox(Actor $actor, bool $linked = false): string
    {
        $linked = !$linked ? ' checked' : RString::EMPTY;
        return '<div><input type="checkbox" name="actors[]" id="actor' . $actor->getId() . '" value="' . $actor->getId() . '"' . $linked . '><label for="actor' . $actor->getId() . '"> ' . $actor->getName() . '</label></div>';
    }

    /**
     * @inheritDoc
     */
    public function display(bool $echo = true): string
    {
        $r = '<div ' . $this->getSignature() . '>' . $this->_sections . '</div>';

        if ($echo) {
            echo $r;
            return RString::EMPTY;
        }

        return $r;
    }
}