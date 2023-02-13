<?php

class BlockSpinner0 extends ABlock
{
    public static function echo(): string
    {
        $w = new BlockSpinner0();
        return $w->display(false);
    }

    /**
     * @inheritDoc
     */
    public function display(bool $echo = true): string
    {
        $r = '<div class="spinner0"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>';

        if ($echo) {
            echo $r;
            return RString::EMPTY;
        }

        return $r;
    }
}