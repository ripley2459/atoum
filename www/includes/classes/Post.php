<?php

class Post extends AContent
{
    /**
     * @inheritDoc
     */
    public static function getType(): EContentType
    {
        return EContentType::POST;
    }
}