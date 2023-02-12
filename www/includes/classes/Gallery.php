<?php

class Gallery extends AContent
{
    /**
     * @inheritDoc
     */
    public static function getType(): EContentType
    {
        return EContentType::GALLERY;
    }
}