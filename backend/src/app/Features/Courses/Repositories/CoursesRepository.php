<?php

namespace App\Features\Courses\Repositories;

use App\Core\Repository;
use App\Core\Services\Database\Database;

class CoursesRepository extends Repository
{
    protected Database $db;

    public function __construct()
    {
        $this->db = appServiceProvider(Database::class);
    }

    public function getAllByTeacherId(string $teacherId): array
    {
        $sql = "SELECT * FROM courses WHERE teacher_id = :teacherid";
        $params = [':teacherid' => $teacherId];

        return $this->db->select($sql, $params);
    }
}
