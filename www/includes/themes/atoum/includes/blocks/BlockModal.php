<?php

class BlockModal extends ABlockContainer
{
    /**
     * @inheritDoc
     */
    public function __construct(string $id = RString::EMPTY, string $classes = RString::EMPTY, string $content = RString::EMPTY)
    {
        parent::__construct($id, $classes, $content);
        RString::concat($this->_classes, RString::SPACE, 'modal');
    }


    /**
     * @inheritDoc
     */
    public function display(): string
    {
        return '<div ' . $this->getSignature() . '><div class="content">' . $this->_content . '</div></div>';
    }
}