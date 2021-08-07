<?php

namespace App\Core\Services\Database;

use PDO;

class Database
{
    private DatabaseConnection $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
        $this->connection->connect();
    }

    public function rawSelect(string $sql): array
    {
        $pdo = $this->connection->getConnection();
        $statement = $pdo->query($sql);
        if (!$statement) {
            return [];
        }
        $results = $statement->fetchAll();
        $statement->closeCursor();
        return $results;
    }

    public function getPdo(): PDO
    {
        return $this->connection->getConnection();
    }
}