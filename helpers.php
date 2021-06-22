<?php

use MDP\DB\Query\Query;

if (!function_exists('query')) {
    function query(): Query {
        return new Query();
    }
}
if (!function_exists('connection')) {
    function connection(): MDP\DB\Connection\Connection {
        return new MDP\DB\Connection\Connection();
    }
}