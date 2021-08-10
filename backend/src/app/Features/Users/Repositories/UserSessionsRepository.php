<?php

namespace App\Features\Users\Repositories;

use App\Core\Repository;
use App\Core\Services\Database\Database;
use App\Shared\Utils\Time;

class UserSessionsRepository extends Repository
{
    const TABLE = 'user_sessions';
    protected Database $db;

    public function __construct()
    {
        $this->db = appServiceProvider(Database::class);
    }

    public function create(
        array $user,
        string $fromDate,
        string $toDate
    ): string
    {
        $data = $this->addHashKey([
            'created_on' => $fromDate,
            'expires_on' => $toDate,
            'user_id' => $user['user_id'],
            'user_role_id' => $user['user_role_id'],
        ]);

        $fields = [];
        $placeholders = [];
        $params = [];

        foreach ($data as $key => $value) {
            $fields[] = $key;
            $placeholders[] = ":{$key}";
            $params[":{$key}"] = $value;
        }

        $table = self::TABLE;
        $fieldsList = implode(',', $fields);
        $placedholdersList = implode(',', $placeholders);
        $sql = "INSERT INTO {$table} ({$fieldsList}) VALUES ({$placedholdersList})";

        $this->db->insert($sql, $params);

        return $data['hash'];
    }

    public function getByHash(string $hash): ?array
    {
        $table = self::TABLE;
        $sql = "SELECT * FROM {$table} WHERE hash = :hash";
        $params = [':hash' => $hash];
        return $this->db->selectFirst($sql, $params);
    }

    public function getByUserId(string $userId): ?array
    {
        $table = self::TABLE;
        $sql = "SELECT * FROM {$table} WHERE user_id = :userid";
        $params = [':userid' => $userId];
        return $this->db->selectFirst($sql, $params);
    }

    public function deleteByUserId(string $userId): int
    {
        $table = self::TABLE;
        $sql = "DELETE FROM {$table} WHERE user_id = :userid";
        $params = [':userid' => $userId];
        return $this->db->execute($sql, $params);
    }

    public function deleteExpired(): int
    {
        $table = self::TABLE;
        $sql = "DELETE FROM {$table} WHERE expires_on < :timestamp";
        $params = [':timestamp' => Time::getDate()];
        return $this->db->execute($sql, $params);
    }

    private function addHashKey(array $data): array
    {
        return array_merge(
            $data,
            ['hash' => substr(hash('sha512', serialize($data)), 0, 50)]
        );
    }
}
