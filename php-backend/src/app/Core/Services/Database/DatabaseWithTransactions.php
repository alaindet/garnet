<?php

namespace App\Core\Services\Database;

use App\Core\Exceptions\Database\DatabaseException;

trait DatabaseWithTransactions
{
    /**
     * Ex.:
     * $this->executeTransaction([
     *     ['UPDATE foo SET name = :name', [':name' => 'Foo']],
     *     ['UPDATE bar SET name = :name', [':name' => 'Bar']],
     * ]);
     *
     * @param array $statements
     * @return void
     */
    public function executeTransaction(array $statements): void
    {
        $pdo = $this->connection->getConnection();

        try {
            $pdo->beginTransaction();

            foreach ($statements as $statement) {

                [$sql, $params] = [null, []];

                if (\is_string($statement)) {
                    $sql = $statement;
                    $params = [];
                } else {
                    $sql = $statement[0];
                    $params = $statement[1] ?? [];
                }

                $stmt = $pdo->prepare($sql);

                if (!empty($params)) {
                    $stmt = $this->bindValues($stmt, $params);
                }

                $stmt->execute();
            }

            $pdo->commit();
        }
        
        catch(\Exception $e) {
            $pdo->rollBack();
            throw new DatabaseException('Could not execute transaction');
        }
    }
}