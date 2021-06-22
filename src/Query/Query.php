<?php

namespace MDP\DB\Query;

use Exception;
use MDP\DB\ValueObjects\QueryType;

class Query
{
    /**
     * Query constructor.
     * @param QueryType|null $queryType
     * @param string $query
     * @param string $table
     * @param string $limitClause
     * @param array $attributes
     */
    public function __construct(
        private QueryType | null $queryType = null,
        private string $query = '',
        private string $table = '',
        private string $limitClause = '',
        private array $attributes = [],
    ) {}

    /**
     * QueryType setter
     * @return $this
     * @throws Exception
     */
    public function find(): self {
        $this->checkIfTypeDefined();
        $this->queryType = QueryType::select();
        return $this;
    }

    /**
     * QueryType setter
     * @return $this
     * @throws Exception
     */
    public function findOne(): self {
        $this->checkIfTypeDefined();
        $this->queryType = QueryType::select();
        $this->limitClause = 'LIMIT 1';
        return $this;
    }

    /**
     * @throws Exception
     */
    private function checkIfTypeDefined(): void {
        if ($this->queryType) {
            throw new Exception('Query type already defined');
        }
    }

    /**
     * QueryType setter
     * @return $this
     * @throws Exception
     */
    public function update(): self {
        $this->checkIfTypeDefined();
        $this->queryType = QueryType::update();
        return $this;
    }

    /**
     * QueryType setter
     * @return $this
     * @throws Exception
     */
    public function delete(int $id): self {
        $this->checkIfTypeDefined();
        $this->queryType = QueryType::delete();
        return $this;
    }

    /**
     * QueryType setter
     * @return $this
     * @throws Exception
     */
    public function insert(): self {
        $this->checkIfTypeDefined();
        $this->queryType = QueryType::insert();
        return $this;
    }

    /**
     * @return QueryType
     */
    public function getQueryType(): QueryType
    {
        return $this->queryType;
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * @param string $query
     */
    public function raw(string $query): void
    {
        $this->queryType = QueryType::raw();
        $this->query = $query;
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @param string $table
     * @return $this
     */
    public function from(string $table): self {
        $this->table = $table;
        return $this;
    }

    /**
     * @return string
     */
    public function getWhereClause(): string
    {
        if (!count($this->attributes)) {
            return '';
        }
        $i = 1;
        $str = /** @lang SQL */ "WHERE ";
        foreach($this->attributes as $key => $value) {
            $and = $i === count($this->attributes) ? '' : 'AND ';
            $str .= "{$key} = :{$key} {$and}";
            $i++;
        }
        return $str;
    }

    private function parseType(string | int $value): int | string
    {
        if (gettype($value) === 'string') {
            return "'{$value}'";
        }
        return $value;
    }

    /**
     * @return string
     */
    public function getLimitClause(): string
    {
        return $this->limitClause;
    }

    /**
     * @param array $attributes
     * @return $this
     */
    public function attributes(array $attributes): self
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return string
     */
    public function parse(): string
    {
        return (new QueryParser)->get($this);
    }
}
