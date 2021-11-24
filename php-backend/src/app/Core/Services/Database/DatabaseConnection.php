<?php

namespace App\Core\Services\Database;

use PDO;

class DatabaseConnection
{
    private PDO $pdo;
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    public function connect(): void
    {
        $dns = (
            "mysql:" .
            "host={$this->config['host']};" .
            "dbname={$this->config['database']};" .
            "charset={$this->config['charset']};" .
            "port={$this->config['port']}"
        );

        $this->pdo = new PDO(
            $dns,
            $this->config['user'],
            $this->config['password'],
            $this->config['options'],
        );
    }
}
