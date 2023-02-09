<?php

class Post extends Content
{
    /**
     * @inheritDoc
     */
    public static function getType(): EContentType
    {
        return EContentType::POST;
    }
}