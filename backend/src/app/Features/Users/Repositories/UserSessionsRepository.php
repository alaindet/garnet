<?php

namespace App\Features\Users\Repositories;

use App\Core\Repository;
use App\Core\Services\Database\Database;

class UserSessionsRepository extends Repository
{
    const TABLE = 'user_sessions';
    protected Database $db;

    public function __construct()
    {
        $this->db = appServiceProvider(Database::class);
    }

    private function addHashKey(array $data): array
    {
        return array_merge(
            $data,
            ['hash' => substr(hash('sha512', serialize($data)), 0, 50)]
        );
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
            'role_id' => $user['role_id'],
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
}
