<?php

class Playlist extends Content
{
    /**
     * @inheritDoc
     */
    public static function getType(): EContentType
    {
        return EContentType::PLAYLIST;
    }
}