<?php

class BlockVideo extends ABlock
{
    public function __construct(string $id = RString::EMPTY, string $classes = RString::EMPTY)
    {
        parent::__construct($id, $classes);
        $this->_classes .= ' video';
    }

    /**
     * @inheritDoc
     */
    public function display(bool $echo = true): string
    {
        $r = '<video ' . $this->getSignature() . ' controls>';

        if ($echo) {
            echo $r;
            return RString::EMPTY;
        }

        return $r;
    }
}