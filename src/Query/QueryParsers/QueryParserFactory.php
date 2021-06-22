<?php

namespace MDP\DB\Query\QueryParsers;

use MDP\DB\ValueObjects\QueryType;

class QueryParserFactory
{
    public static function make(QueryType $type): QueryParserStrategy
    {
        switch($type) {
            case QueryType::select():
                return new SelectQueryParserStrategy();
            case QueryType::insert():
                return new InsertQueryParserStrategy();
            case QueryType::update():
                return new UpdateQueryParserStrategy();
            case QueryType::delete():
                return new DeleteQueryParserStrategy();
        }
    }
}