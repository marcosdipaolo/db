<?php

namespace MDP\DB\Connection;

interface ConnectionInterface
{
    public function getPdo(): \PDO;
}