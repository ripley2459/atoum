<?php

class Researcher
{
    private static ?Researcher $_instance = null;
    private ?EDataType $_type;
    private ?EDataStatus $_status;
    private ?string $_orderBy;
    private ?string $_orderDirection;
    private int $_limit;
    private string $_searchFor;
    private int $_currentPage;
    private int $_totalPages;
    private bool $_displayContent;

    private function __construct()
    {
        $this->_type = isset($_GET['type']) ? EDataType::from($_GET['type']) : null;
        $this->_status = isset($_GET['status']) ? EDataStatus::from($_GET['status']) : null;
        $this->_orderBy = $_GET['orderBy'] ?? null;
        $this->_orderDirection = isset($this->_orderBy) ? switchOrderDirection($this->_orderBy) : 'ASC';
        $this->_limit = $_GET['limit'] ?? 100;
        $this->_searchFor = $_GET['searchFor'] ?? RString::EMPTY;
        $this->_currentPage = $_GET['currentPage'] ?? 1;
        $this->_totalPages = ceil(AContent::getAmount($this->_type) / $this->_limit);
        $this->_displayContent = isset($_GET['displayContent']);
    }

    /**
     * Singleton.
     * @return Researcher
     */
    public static function Instance(): Researcher
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Researcher();
        }

        return self::$_instance;
    }

    /**
     * @param EDataType|null $type
     */
    public function setType(?EDataType $type): void
    {
        $this->_type = $type;
    }

    /**
     * @param EDataStatus|null $status
     */
    public function setStatus(?EDataStatus $status): void
    {
        $this->_status = $status;
    }

    /**
     * @param string|null $orderBy
     */
    public function setOrderBy(?string $orderBy): void
    {
        $this->_orderBy = $orderBy;
    }

    /**
     * @param string|null $orderDirection
     */
    public function setOrderDirection(?string $orderDirection): void
    {
        $this->_orderDirection = $orderDirection;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit): void
    {
        $this->_limit = $limit;
    }

    /**
     * @param string $searchFor
     */
    public function setSearchFor(string $searchFor): void
    {
        $this->_searchFor = $searchFor;
    }

    /**
     * @param int $currentPage
     */
    public function setCurrentPage(int $currentPage): void
    {
        $this->_currentPage = $currentPage;
    }

    /**
     * @param int $totalPages
     */
    public function setTotalPages(int $totalPages): void
    {
        $this->_totalPages = $totalPages;
    }

    /**
     * @param bool $displayContent
     */
    public function setDisplayContent(bool $displayContent): void
    {
        $this->_displayContent = $displayContent;
    }

    /**
     * @return EDataType|null
     */
    public function getType(): ?EDataType
    {
        return $this->_type;
    }

    /**
     * @return EDataStatus|null
     */
    public function getStatus(): ?EDataStatus
    {
        return $this->_status;
    }

    /**
     * @return string|null
     */
    public function getOrderBy(): ?string
    {
        return $this->_orderBy;
    }

    /**
     * @return string
     */
    public function getOrderDirection(): string
    {
        return $this->_orderDirection;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->_limit;
    }

    /**
     * @return string
     */
    public function getSearchFor(): string
    {
        return $this->_searchFor;
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->_currentPage;
    }

    /**
     * @return int
     */
    public function getTotalPages(): int
    {
        return $this->_totalPages;
    }

    /**
     * @return bool
     */
    public function getDisplayContent(): bool
    {
        return $this->_displayContent;
    }
}