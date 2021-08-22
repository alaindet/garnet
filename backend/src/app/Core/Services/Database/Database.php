<?php

namespace App\Core\Services\Database;

use PDO;

use App\Core\Exceptions\Database\DatabaseException;

class Database
{
    use DatabaseWithRawStatements;
    use DatabaseWithTransactions;
    use DatabaseWithPreparedStatements;

    private DatabaseConnection $connection;

    public function __construct(DatabaseConnection $connection)
    {
        $this->connection = $connection;
        $this->connection->connect();
    }

    public function getPdo(): PDO
    {
        return $this->connection->getConnection();
    }

    public function execute(string $sql, array $params = []): int
    {
        $query = $this->getPreparedStatement($sql, $params);
        $executed = $query->execute();

        if (!$executed) {
            throw new DatabaseException('Could not execute query');
        }

        return $query->rowCount();
    }

    public function select(
        string $sql,
        array $params = [],
        string $className = null
    ): array
    {
        $query = $this->getPreparedStatement($sql, $params);

        if (!$query->execute()) {
            throw new DatabaseException('Could not execute query');
        }

        $result = isset($className)
            ? $query->fetchAll(PDO::FETCH_CLASS, $className)
            : $query->fetchAll();

        return ($result === false) ? [] : $result;
    }

    public function selectFirst(
        string $sql,
        array $params = [],
        string $className = null
    ): array|null
    {
        $result = $this->select($sql, $params, $className);
        return $result[0] ?? null;
    }

    public function insert(string $sql, array $params = []): int
    {
        $query = $this->getPreparedStatement($sql, $params);

        if (!$query->execute()) {
            throw new DatabaseException('Could not insert into database');
        }

        return $this->connection->getConnection()->lastInsertId();
    }
}
