<?php

abstract class ABlockContainer extends ABlock
{
    protected string $_content = R::EMPTY;

    public function __construct(string $id = R::EMPTY, string $classes = R::EMPTY, string $content = R::EMPTY)
    {
        parent::__construct($id, $classes);
        R::append($this->_classes, R::SPACE, 'container');
        $this->_content = $content;
    }
}