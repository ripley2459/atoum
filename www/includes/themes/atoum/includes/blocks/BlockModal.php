<?php

class BlockModal extends ABlockContainer
{
    /**
     * @inheritDoc
     */
    public function display(bool $echo = true): string
    {
        $this->_classes[] = 'modal';
        $r = '<div id="' . $this->_id . '" class="' . implode(" ", $this->_classes) . '"><div class="content">' . $this->_content . '</div></div>';

        if ($echo) {
            echo $r;
            return RString::EMPTY;
        }

        return $r;
    }
}