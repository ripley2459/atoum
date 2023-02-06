<?php

class BlockSpinner0 implements IBlockNP
{
    /**
     * @inheritDoc
     */
    public static function echoS(): void
    {
        $n = new BlockSpinner0();
        $n->echo();
    }

    /**
     * @inheritDoc
     */
    public function echo(): void
    {
        echo $this->display();
    }

    /**
     * @inheritDoc
     */
    public function display(): string
    {
        return '<div class="spinner0"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>';
    }
}