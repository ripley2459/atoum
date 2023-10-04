<?php

class BlockToTop extends ABlock
{
    public function __construct(string $classes = RString::EMPTY)
    {
        parent::__construct('toTop', $classes);
    }

    /**
     * @inheritDoc
     */
    public function display(): string
    {
        return '<button '. $this->getSignature() . ' onclick="toTop()" title="Go to top">Top</button>';
    }
}