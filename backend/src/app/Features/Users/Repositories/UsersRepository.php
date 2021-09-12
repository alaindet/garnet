<?php

namespace App\Features\Users\Repositories;

use App\Core\Repository;
use App\Core\Services\Database\Database;

class UsersRepository extends Repository
{
    protected $table = 'users';
    protected Database $db;

    public function __construct()
    {
        $this->db = appServiceProvider(Database::class);
    }

    public function getUserProfile(string|int $userId): array|null
    {
        $sql = "
            SELECT
                u.user_id,
                u.created_on,
                u.first_name,
                u.last_name,
                ur.name AS role,
                u.email
            FROM
                {$this->table} AS u
                INNER JOIN user_roles AS ur ON u.user_role_id = ur.user_role_id
            WHERE u.user_id = :userid
        ";

        $params = [':userid' => $userId];

        return $this->db->selectFirst($sql, $params);
    }

    public function findUserByEmail(
        string $email,
        string|array $_fields = '*'
    ): array|null
    {
        $fields = \is_array($_fields)
            ? \implode(',', $_fields)
            : $_fields;

        $sql = "SELECT {$fields} FROM {$this->table} WHERE email = :email";
        $params = [':email' => $email];

        return $this->db->selectFirst($sql, $params);
    }
}
