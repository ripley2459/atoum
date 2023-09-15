<?php

class BlockTable extends ABlockContainer
{
    protected bool $_dynamic = false;
    protected array $_columns = array();
    protected array $_rows = array();

    public function __construct(string $id = R::EMPTY, string $classes = R::EMPTY, string $content = R::EMPTY)
    {
        parent::__construct($id, $classes, $content);
        R::append($this->_classes, R::SPACE, 'u-full-width');
    }

    public function display(): string
    {
        $table = $this->getStart();

        if (!$this->_dynamic) {
            // TODO
        }

        return $table . $this->getEnd();
    }

    public function getStart(): string
    {
        return '<table ' . $this->signature() . '><thead><tr>' . implode(R::EMPTY, $this->_columns) . '</tr></thead><tbody id="' . $this->_id . '-content">';
    }

    public function getEnd(): string
    {
        return '</tbody></table>';
    }

    public function dynamic(): void
    {
        $this->_dynamic = true;
    }

    public function addColumn(string $name): void
    {
        $this->_columns[] = '<th>' . $name . '</th>';
    }

    public function addRow(string...$values): void
    {
        $row = array();
        $row[] = $values;
        $this->_rows[] = $row;
    }

    public function TableLess(): string
    {
        return '<div id="' . $this->_id . '-content"></div>';
    }
}