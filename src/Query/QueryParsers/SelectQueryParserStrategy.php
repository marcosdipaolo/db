<?php

namespace MDP\DB\Query\QueryParsers;

use MDP\DB\Query\Query;

class SelectQueryParserStrategy implements QueryParserStrategy
{
    public function parse(Query $query): string
    {
        return /** @lang SQL */"SELECT * FROM {$query->getTable()} {$query->getWhereClause()} {$query->getLimitClause()}";
    }
}