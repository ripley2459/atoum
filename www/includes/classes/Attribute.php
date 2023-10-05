<?php

class Attribute
{
    protected string $_id;
    protected string $_classes;

    /**
     * @param string $id
     * @param string $classes
     */
    public function __construct(string $id = R::EMPTY, string $classes = R::EMPTY)
    {
        $this->_id = $id;
        $this->_classes = $classes;
    }

    public function __toString(): string
    {
        $r = R::EMPTY;
        if (!R::nullOrEmpty($this->_id)) $r .= 'id="' . $this->_id . '"';
        if (!R::nullOrEmpty($this->_classes)) $r .= 'class="' . $this->_classes . '"';

        return $r;
    }
}