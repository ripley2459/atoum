<?php

class Request
{
    private string $_operation;
    private string $_table;
    private string $_columns;
    private array $_where = array();
    private string $_orderBy;
    private int $_limit;
    private int $_offset;
    private string $_subOperation;
    private Request $_sub;
    private ?PDOStatement $_request = null;

    public function __construct(string $operation, string $table, string $columns)
    {
        $this->_operation = $operation;
        $this->_table = $table;
        $this->_columns = $columns;
    }

    public static function select(string $table, string...$columns): Request
    {
        R::prefix($table . '.', $columns);
        return new Request('SELECT', $table, implode(', ', $columns));
    }

    public static function selectDistinct(string $table, string...$columns): Request
    {
        R::prefix($table . '.', $columns);
        return new Request('SELECT DISTINCT', $table, implode(', ', $columns));
    }

    public function __destruct()
    {
        $this->_request?->closecursor();
    }

    public function orderBy(string $orderBy): Request
    {
        $this->_orderBy = $orderBy;
        return $this;
    }

    public function limit(int $limit): Request
    {
        $this->_limit = $limit;
        return $this;
    }

    public function offset(int $offset): Request
    {
        $this->_offset = $offset;
        return $this;
    }

    public function sub(string $subOperation, Request $sub): Request
    {
        $this->_subOperation = $subOperation;
        $this->_sub = $sub;
        return $this;
    }

    /**
     * @return PDOStatement The ready to fetch data.
     */
    public function execute(): PDOStatement
    {
        if ($this->_request == null) $this->prepare();
        $this->bindValues($this->_request);
        R::checkArgument($this->_request->execute());
        return $this->_request;
    }

    private function prepare(): void
    {
        global $DDB;
        $this->_request = $DDB->prepare($this->getStatement());
    }

    public function getStatement(): string
    {
        $s = $this->_operation . R::SPACE . $this->_columns . ' FROM ' . $this->_table;

        if (count($this->_where) > 0 || isset($this->_sub)) $s .= ' WHERE ';

        if (isset($this->_sub)) $s .= $this->_subOperation . ' (' . $this->_sub->getStatement() . ')';
        if (count($this->_where) > 0) {
            if (isset($this->_sub)) $s .= ' AND ';
            $s .= str_replace('#', '.', $this->_where[0][0]) . ' ' . $this->_where[0][1] . ' :' . str_replace('#', '_', $this->_where[0][0]);
            for ($i = 1; $i < count($this->_where); $i++) {
                $s .= ' AND ' . str_replace('#', '.', $this->_where[$i][0]) . ' ' . $this->_where[$i][1] . ' :' . str_replace('#', '_', $this->_where[$i][0]);
            }
        }

        if (isset($this->_orderBy) && !R::nullOrEmpty($this->_orderBy)) {
            $order = explode('_', $this->_orderBy);
            $s .= ' ORDER BY ' . $order[0] . ' ' . $order[1];
        }

        if (isset($this->_limit) && isset($this->_offset)) $s .= ' LIMIT :limitMin, :limitMax';

        return $s;
    }

    private function bindValues(PDOStatement &$request): void
    {
        foreach ($this->_where as $where) {
            $request->bindValue(':' . str_replace('#', '_', $where[0]), $where[2], self::getParamType($where[2]));
        }

        if (isset($this->_limit) && isset($this->_offset)) {
            $request->bindValue(':limitMin', $this->_offset * $this->_limit - $this->_limit, PDO::PARAM_INT);
            $request->bindValue(':limitMax', $this->_limit, PDO::PARAM_INT);
        }

        if (isset($this->_sub)) $this->_sub->bindValues($request);
    }

    private static function getParamType(mixed $param): int
    {
        if (is_string($param)) return PDO::PARAM_STR;
        if (is_int($param)) return PDO::PARAM_INT;
        if (is_bool($param)) return PDO::PARAM_BOOL;
        return PDO::PARAM_STR;
    }

    public function where(string $column, string $operation, mixed $value): Request
    {
        if ($operation == 'LIKE' && is_string($value) && !R::nullOrEmpty($value)) $value = '%' . $value . '%'; // Special case. TODO
        if (isset($value)) $this->_where[] = [$this->_table . '#' . $column, $operation, $value];
        return $this;
    }

    private function getWheres(): array
    {
        return $this->_where;
    }

    private function subWhere(string $column, string $operation, mixed $value): Request
    {
        if ($operation == 'LIKE') $value = '%' . $value . '%'; // Special case. TODO
        if (isset($value)) $this->_where[] = [$column, $operation, $value];
        return $this;

        return $this;
    }
}