<?php

class Playlist extends AContent
{
    /**
     * @inheritDoc
     */
    public static function getType(): EDataType
    {
        return EDataType::PLAYLIST;
    }

    /**
     * @inheritDoc
     */
    public function display(): string
    {
        return $this->_name;
    }
}