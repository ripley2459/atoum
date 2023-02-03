<?php

class Image extends Content
{
    /**
     * @inheritDoc
     */
    public static function getType(): EContentType
    {
        return EContentType::IMAGE;
    }

    /**
     * @inheritDoc
     */
    public static function getInstance(): Content
    {
        // TODO: Implement getInstance() method.
    }
}