<?php

class Tag extends AContent
{
    /**
     * @inheritDoc
     */
    public static function getType(): EDataType
    {
        return EDataType::TAG;
    }

    /**
     * @inheritDoc
     */
    public function display(): string
    {
        return $this->_name;
    }
}