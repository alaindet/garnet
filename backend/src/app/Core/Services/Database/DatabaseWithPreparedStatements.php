<?php

namespace App\Core\Services\Database;

use PDO;
use PDOStatement;

trait DatabaseWithPreparedStatements
{
    private $paramFlags = [
        'string' => PDO::PARAM_STR,
        'integer' => PDO::PARAM_INT,
        'boolean' => PDO::PARAM_BOOL,
        'NULL' => PDO::PARAM_NULL,
    ];

    protected function getPreparedStatement(
        string $sql,
        array $params
    ): PDOStatement
    {
        $pdo = $this->connection->getConnection();
        $query = $pdo->prepare($sql);
        $query = $this->bindValues($query, $params);
        return $query;
    }

    /**
     * Binds passed values to placeholders in the passed prepared statement
     * 
     * Ex.:
     * $this->bindValues([':name' => 'Foo'])
     *
     * @param PDOStatement $query
     * @param array $values
     * @return PDOStatement
     */
    private function bindValues(
        PDOStatement $query,
        array $values = null
    ): PDOStatement
    {
        foreach ($values as $placeholder => $value) {
            $type = gettype($value);
            $flag = $this->paramFlags[$type];
            $query->bindValue($placeholder, $value, $flag);
        }

        return $query;
    }
}