<?php

namespace App\Features\Users\Repositories;

use App\Core\Repository;
use App\Core\Services\Database\Database;

class UserRolesRepository extends Repository
{
    const TABLE = 'user_roles';
    const TEACHER = 1;
    const STUDENT = 2;

    protected Database $db;

    public function __construct()
    {
        $this->db = appServiceProvider(Database::class);
    }
}
