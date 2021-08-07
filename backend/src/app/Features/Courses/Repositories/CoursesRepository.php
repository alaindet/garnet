<?php

namespace App\Features\Courses\Repositories;

use App\Core\Services\Database\Database;
use App\Features\Courses\Dtos\CreateCourseDto;

class CoursesRepository
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
