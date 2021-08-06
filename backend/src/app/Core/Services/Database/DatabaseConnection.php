<?php

namespace App\Core\Services\Database;

use PDO;

trait DatabaseConnection
{
    protected PDO $pdo;

    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    protected function connect(array $databaseConfig): void
    {
        $dns = (
            "mysql:" .
            "host={$databaseConfig['host']};" .
            "dbname={$databaseConfig['database']};" .
            "charset={$databaseConfig['charset']};" .
            "port={$databaseConfig['port']}"
        );

        $this->pdo = new PDO(
            $dns,
            $databaseConfig['user'],
            $databaseConfig['password'],
            $databaseConfig['options'],
        );
    }
}
