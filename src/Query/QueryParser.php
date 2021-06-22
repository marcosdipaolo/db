<?php

namespace MDP\DB\Query;

use MDP\DB\Query\QueryParsers\QueryParserFactory;

class QueryParser
{
    public function get(Query $query): string
    {
        return QueryParserFactory::make($query->getQueryType())->parse($query);
    }

    private function parseAttributes(array $attributes): string {
        $str = '';
        foreach(array_keys($attributes) as $index => $attr){
            $comma = $index + 1 === count($attributes) ? '' : ',';
            $str.= ":{$attr}{$comma}";
        }
        return $str;
    }
}