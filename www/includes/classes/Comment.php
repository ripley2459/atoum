<?php

class Comment extends AContent
{
    /**
     * @inheritDoc
     */
    public static function getType(): EDataType
    {
        // TODO: Implement getType() method.
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