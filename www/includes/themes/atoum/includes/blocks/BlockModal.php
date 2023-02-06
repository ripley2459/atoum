<?php

class BlockModal extends ABlockContainer
{
    /**
     * @inheritDoc
     */
    public function display(): string
    {
        $this->_classes[] = 'modal';
        return '<div id="' . $this->_id . '" class="' . implode(" ", $this->_classes) . '"><div class="content">' . $this->_content . '</div></div>';
    }
}