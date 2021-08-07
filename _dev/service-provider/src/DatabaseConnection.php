<?php

namespace App;

use PDO;

class DatabaseConnection
{
    private $config;
    private PDO $pdo;

    public function __construct(array $config)
    {
        echo 'DatabaseConnection::__construct';
        $this->config = $config;
        $this->connect();
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