<?php

class Gallery extends Content
{
    /**
     * @inheritDoc
     */
    public static function getType(): EContentType
    {
        return EContentType::GALLERY;
    }
}