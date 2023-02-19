<?php

class Post extends AContent
{
    /**
     * @inheritDoc
     */
    public static function getType(): EDataType
    {
        return EDataType::POST;
    }
}