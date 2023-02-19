<?php

class Gallery extends AContent
{
    /**
     * @inheritDoc
     */
    public static function getType(): EDataType
    {
        return EDataType::GALLERY;
    }
}