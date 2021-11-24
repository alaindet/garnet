<?php

namespace App\Core\Services\Database;

trait DatabaseWithRawStatements
{
    public function rawExecute(string $statement): int
    {
        return $this->connection->getConnection()->exec($statement);
    }

    public function rawSelect(string $sql): array
    {
        $pdo = $this->connection->getConnection();
        $stmt = $pdo->query($sql);

        if (!$stmt) {
            return [];
        }

        $results = $stmt->fetchAll();
        $stmt->closeCursor();

        return ($results === false) ? [] : $results;
    }

    public function rawCount(
        string $table,
        string $idField = 'id',
        string $where = '1'
    ): int
    {
        $sql = "
            SELECT COUNT(`{$idField}`) as `count`
            FROM {$table}
            WHERE {$where}
        ";

        $raw = $this->rawSelect($sql);

        return $raw[0]
            ? (int) $raw[0]['count']
            : 0;
    }

    public function resetAutoIncrement(string $table): int
    {
        return $this->rawExecute("ALTER TABLE `{$table}` AUTO_INCREMENT = 1");
    }
}