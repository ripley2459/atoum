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
        $this->_classes .= ' grid';
    }

    /**
     * @inheritDoc
     */
    public function display(bool $echo = true): string
    {
        $r = '<div ' . $this->getSignature() . ' style="column-count: ' . $this->_columnCount . '">' . $this->content . '</div>';

        if ($echo) {
            echo $r;
            return RString::EMPTY;
        }

        return $r;
    }

    /**
     * Ajoute un élément à cette grille.
     * @param string $element
     * @return void
     */
    public function addElement(string $element): void
    {
        $this->content .= $element;
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