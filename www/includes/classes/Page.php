<?php

class Page extends Content
{
    /**
     * @inheritDoc
     */
    public static function getType(): EContentType
    {
        return EContentType::PAGE;
    }
}