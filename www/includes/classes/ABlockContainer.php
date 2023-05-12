<?php

abstract class ABlockContainer extends ABlock
{
    protected string $_content = RString::EMPTY;

    /**
     * @param string $id
     * @param string $classes
     * @param string $content
     */
    public function __construct(string $id = RString::EMPTY, string $classes = RString::EMPTY, string $content = RString::EMPTY)
    {
        parent::__construct($id, $classes);
        RString::concat($this->_classes, RString::SPACE, 'container');
        $this->_content = $content;
    }

    public function addContent(string $newContent): void
    {
        RString::concat($this->_content, RString::EMPTY, $newContent);
    }
}