<?php

class BlockCollapsible extends ABlockContainer
{
    protected string $_text;

    public function __construct(string $text, string $id, string $classes = RString::EMPTY)
    {
        parent::__construct($id, $classes);
        $this->_classes .= ' collapsible';
        $this->_text = $text;
    }

    /**
     * @inheritDoc
     */
    public function display(): string
    {
        return '<div ' . $this->getSignature() . '><button onclick="toggleCollapse(\'' . $this->_id . '\')">' . $this->_text . '</button><div class="content">' . $this->_content . '</div></div>';
    }
}