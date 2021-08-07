<?php

namespace App\Features\Users\Repositories;

use App\Core\Repository;
use App\Core\Services\Database\Database;

class UsersRepository extends Repository
{
    const TABLE = 'users';
    protected Database $db;

    public function __construct()
    {
        $this->db = appServiceProvider(Database::class);
    }

    public function findUserByEmail(string $email, $_fields = '*')
    {
        $fields = \is_array($_fields)
            ? \implode(',', $_fields)
            : $_fields;

        $table = self::TABLE;

        $sql = "SELECT {$fields} FROM {$table} WHERE email = :email";
        $params = [':email' => $email];

        return $this->db->selectFirst($sql, $params);
    }
}
