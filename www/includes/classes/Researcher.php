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
     * @return Researcher|null
     */
    public static function getInstance(): ?Researcher
    {
        return self::$_instance;
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