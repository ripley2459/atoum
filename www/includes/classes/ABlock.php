<?php

abstract class ABlock
{
    protected string $_id;
    protected string $_classes;

    public function __construct(string $id = RString::EMPTY, string $classes = RString::EMPTY)
    {
        $this->_id = $id;
        $this->_classes = $classes;
    }

    /**
     * Donne le code HTML pour afficher ce block.
     * @param bool $echo Si le bloc doit être retourné ou afficher via echo
     * @return string
     */
    public abstract function display(bool $echo = true): string;

    protected function getSignature(): string
    {
        $r = '';

        if (!nullOrEmpty($this->_id)) $r .= 'id="' . $this->_id . '"';
        if (!nullOrEmpty($this->_classes)) $r .= 'class="' . $this->_classes . '"';

        return $r;
    }
}