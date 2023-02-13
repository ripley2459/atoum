<?php

class RString
{
    public const EMPTY = '';
    private string $_content;

    public function __construct()
    {
        $this->_content = self::EMPTY;
    }

    /**
     * @return string
     */
    public function display(): string
    {
        return $this->_content;
    }
}