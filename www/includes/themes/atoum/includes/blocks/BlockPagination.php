<?php

class BlockPagination extends ABlockContainer
{
    protected string $_label;
    protected int $_currentPage;
    protected int $_totalPages;
    protected string $_onChangePage;

    public function __construct(string $id, string $label = RString::EMPTY, int $currentPage = 0, int $totalPages = 1, string $onChangePage = RString::EMPTY, string...$classes)
    {
        parent::__construct($id, RString::EMPTY, implode(" ", $classes));
        $this->_content .= '<div>';
        $this->_label = $label;
        $this->_currentPage = $currentPage;
        $this->_totalPages = $totalPages;
        $this->_onChangePage = $onChangePage;
    }

    /**
     * @param int $amount
     * @return void
     */
    public function addLimitButton(int $amount): void
    {
        $this->_content .= '<button onclick="setLimit(' . $amount . ')">' . $amount . '</button>';
    }

    /**
     * @inheritDoc
     */
    public function display(bool $echo = true): string
    {
        $r = $this->_content;

        $r .= $this->getPreviousPage();
        $r .= $this->_currentPage . '/' . $this->_totalPages;
        $r .= $this->getNextPage();
        $r .= '</div>';

        if ($echo) {
            echo $r;
            return RString::EMPTY;
        }

        return $r;
    }

    /**
     * @return string
     */
    private function getPreviousPage(): string
    {
        if ($this->_currentPage == 1) {
            return '<button onclick="setCurrentPage(' . $this->_currentPage - 1 . ')" disabled><</button>';
        }

        return '<button onclick="setCurrentPage(' . $this->_currentPage - 1 . ')"><</button>';
    }

    /**
     * @return string
     */
    private function getNextPage(): string
    {
        if ($this->_currentPage == $this->_totalPages) {
            return '<button onclick="setCurrentPage(' . $this->_currentPage + 1 . ')" disabled>></button>';
        }

        return '<button onclick="setCurrentPage(' . $this->_currentPage + 1 . ')">></button>';
    }
}