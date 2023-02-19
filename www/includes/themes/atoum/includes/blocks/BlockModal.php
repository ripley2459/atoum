<?php

class BlockModal extends ABlockContainer
{
    /**
     * @inheritDoc
     */
    public function __construct(string $id = RString::EMPTY, string $classes = RString::EMPTY, string $content = RString::EMPTY)
    {
        parent::__construct($id, $classes, $content);
        $this->_classes .= ' modal';
    }


    /**
     * @inheritDoc
     */
    public function display(bool $echo = true): string
    {
        $r = '<div ' . $this->getSignature() . '><div class="content">' . $this->_content . '</div></div>';

        if ($echo) {
            echo $r;
            return RString::EMPTY;
        }

        return $r;
    }
}