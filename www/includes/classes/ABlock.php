<?php

abstract class ABlock
{
    protected string $_id;
    protected string $_classes;

    public function __construct(string $id = R::EMPTY, string $classes = R::EMPTY)
    {
        $this->_id = $id;
        $this->_classes = $classes;
    }

    /**
     * Affiche ce widget.
     * @return string
     */
    public abstract function display(): string;

    /**
     * Donne l'id et les classes de ce widget utilisable dans une balise HTML.
     * @return string
     */
    protected function signature(): string
    {
        $r = R::EMPTY;
        if (!R::nullOrEmpty($this->_id)) $r .= 'id="' . $this->_id . '"';
        if (!R::nullOrEmpty($this->_classes)) $r .= 'class="' . $this->_classes . '"';
        return $r;
    }
}