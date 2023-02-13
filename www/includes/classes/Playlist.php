<?php

class Playlist extends AContent
{
    /**
     * @inheritDoc
     */
    public static function getType(): EContentType
    {
        return EContentType::PLAYLIST;
    }
}