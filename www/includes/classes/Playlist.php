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
    public function display(bool $echo = true): string
    {
        $r = '';

        if ($echo) {
            echo $r;
            return RString::EMPTY;
        }

        return $r;
    }
}