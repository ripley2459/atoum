<?php

class Page extends AContent
{
    /**
     * @inheritDoc
     */
    public static function getType(): EContentType
    {
        return EContentType::PAGE;
    }
}