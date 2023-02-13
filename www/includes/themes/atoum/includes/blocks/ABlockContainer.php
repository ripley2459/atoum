<?php

abstract class ABlockContainer extends ABlock
{
    protected string $_id;
    protected array $_classes;
    protected string $_content;

    /**
     * @param string $id
     * @param string $content
     * @param string ...$classes
     */
    public function __construct(string $id, string $content = RString::EMPTY, string...$classes)
    {
        $this->_id = $id;
        $this->_content = $content;
        $this->_classes[] = 'container';
        if (count($classes) > 0) $this->_classes[] = $classes;
    }
}