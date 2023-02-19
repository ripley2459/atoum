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
}