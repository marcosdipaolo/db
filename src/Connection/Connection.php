<?php

namespace MDP\DB\Connection;

use Dotenv\Dotenv;
use MDP\DB\Query\Query;
use MDP\DB\ValueObjects\QueryType;
use PDO;

class Connection implements ConnectionInterface
{
    private string|array|false $dbname;
    private string|array|false $username;
    private string|array|false $password;
    private string|array|false $host;
    private string|array|false $port;
    private string|array|false $dialect;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . "/../../");
        $dotenv->load();
        $this->dbname = $_ENV['DB_NAME'];
        $this->username = $_ENV['DB_USER'];
        $this->password  = $_ENV['DB_PASSWORD'];
        $this->host  = $_ENV['DB_HOST'];
        $this->port  = $_ENV['DB_PORT'];
        $this->dialect  = $_ENV['DB_DIALECT'];
    }

    /**
     * @return PDO
     */
    public function getPdo(): PDO
    {
        $dsn = "{$this->dialect}:host={$this->host};port={$this->port};dbname={$this->dbname}";
        $pdo = new PDO($dsn, $this->username, $this->password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return  $pdo;
    }

    /**
     * @return mixed
     */
    public function getDbname(): mixed
    {
        return $this->dbname;
    }

    /**
     * @return mixed
     */
    public function getUsername(): mixed
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getPassword(): mixed
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getHost(): mixed
    {
        return $this->host;
    }

    /**
     * @return mixed
     */
    public function getPort(): mixed
    {
        return $this->port;
    }

    public function query(Query $query): bool | \stdClass | array {
        $pdo = $this->getPdo();
        $queryType = $query->getQueryType();
        $pdoStatement = $pdo->prepare($query->parse());
        $pdoStatement->execute($query->getAttributes());
        switch($queryType) {
            case QueryType::select():
                if ($query->getLimitClause() === 'LIMIT 1') {
                    return $pdoStatement->fetch(PDO::FETCH_ASSOC);
                }
                return $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
            case QueryType::insert():
            case QueryType::update():
            case QueryType::delete():
                return $pdoStatement->execute($query->getAttributes());
            default:
                return false;
        }
    }
}
