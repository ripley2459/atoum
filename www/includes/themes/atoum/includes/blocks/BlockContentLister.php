<?php

class BlockContentLister extends ABlockContainer
{
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