<?php

class Movie extends Content
{
    /**
     * @inheritDoc
     */
    public static function getType(): EContentType
    {
        return EContentType::MOVIE;
    }

    /**
     * @inheritDoc
     */
    public static function getInstance(): Content
    {
        // TODO: Implement getInstance() method.
    }
}