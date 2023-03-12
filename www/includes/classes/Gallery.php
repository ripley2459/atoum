<?php

class Gallery extends AContent
{
    /**
     * @inheritDoc
     */
    public static function getType(): EDataType
    {
        return EDataType::GALLERY;
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