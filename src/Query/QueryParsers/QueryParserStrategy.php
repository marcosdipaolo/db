<?php

namespace MDP\DB\Query\QueryParsers;

use MDP\DB\Query\Query;

interface QueryParserStrategy
{
    public function parse(Query $query): string;
}