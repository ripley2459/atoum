<?php

class BlockGrid extends ABlockContainer
{
    private int $_columnCount = 4;

    /**
     * @inheritDoc
     */
    public function __construct(string $id = RString::EMPTY, string $classes = RString::EMPTY)
    {
        parent::__construct($id, $classes);
        RString::concat($this->_classes, RString::SPACE, 'grid');
    }

    /**
     * @inheritDoc
     */
    public function display(): string
    {
        return '<div ' . $this->getSignature() . ' style="column-count: ' . $this->_columnCount . '">' . $this->_content . '</div>';
    }

    /**
     * Change le nombre de colonnes de ce bloc.
     * @param int $newCount
     * @return void
     */
    public function setColumnCount(int $newCount): void
    {
        $this->_columnCount = $newCount;
    }
}