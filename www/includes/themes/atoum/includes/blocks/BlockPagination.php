<?php

class BlockPagination extends ABlockContainer
{
    protected string $_label;
    protected int $_currentPage;
    protected int $_totalPages;

    /**
     * Fonction JS appelé quand on change de page.
     * @var string
     */
    protected string $_onChangePage;

    /**
     * @inheritDoc
     */
    public function __construct(string $id = RString::EMPTY, string $classes = RString::EMPTY, string $label = RString::EMPTY, int $currentPage = 0, int $totalPages = 1, string $onChangePage = RString::EMPTY)
    {
        parent::__construct($id, $classes);
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
        $this->_content .= '<button onclick="setURLParam(\'limit\', ' . $amount . ', ' . $this->_onChangePage . ')">' . $amount . '</button>';
    }

    /**
     * @inheritDoc
     */
    public function display(bool $echo = true): string
    {
        $r = '<div ' . $this->getSignature() . '>';
        $r .= $this->_content;
        $r .= $this->getPreviousPage();
        $r .= '<spawn>' . $this->_currentPage . '/' . $this->_totalPages . '</spawn>';
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
            return '<button onclick="setURLParam(\'currentPage\', ' . $this->_currentPage - 1 . ', ' . $this->_onChangePage . ')" disabled><</button>';
        }

        return '<button onclick="setURLParam(\'currentPage\', ' . $this->_currentPage - 1 . ', ' . $this->_onChangePage . ')"><</button>';
    }

    /**
     * @return string
     */
    private function getNextPage(): string
    {
        if ($this->_currentPage == $this->_totalPages) {
            return '<button onclick="setURLParam(\'currentPage\', ' . $this->_currentPage + 1 . ', ' . $this->_onChangePage . ')" disabled>></button>';
        }

        return '<button onclick="setURLParam(\'currentPage\', ' . $this->_currentPage + 1 . ', ' . $this->_onChangePage . ')">></button>';
    }

    public function addSearchForm(string $onSearch = RString::EMPTY): void
    {
        $this->_content .= '<input type="text" id="' . $this->_id . 'Search" onkeyup="setURLParam(\'searchFor\', value' . ($onSearch == RString::EMPTY ? '' : ', ' . $onSearch) . ')"/>';
    }

    public function addCustomElement(string $element): void
    {
        $this->_content .= $element;
    }
}