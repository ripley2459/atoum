<?php

class Page extends AContent
{
    /**
     * @inheritDoc
     */
    public static function getType(): EDataType
    {
        return EDataType::PAGE;
    }

    /**
     * @inheritDoc
     */
    public function display(): string
    {
        return $this->_content;
    }
}