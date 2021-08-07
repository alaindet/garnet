<?php

namespace App;

use PDO;

class Database
{
    private DatabaseConnection $connection;
    private PDO $pdo;

    public function __construct(DatabaseConnection $connection)
    {
        echo 'DatabaseConnection::__construct';
        $this->connection = $connection;
        $this->pdo = $this->connection->getConnection();
    }

    public function select(string $sql)
    {
        $query = $this->pdo->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}