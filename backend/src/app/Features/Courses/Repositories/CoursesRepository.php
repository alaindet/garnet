<?php

namespace App\Features\Courses\Repositories;

use App\Core\Repository;
use App\Core\Services\Database\Database;

class CoursesRepository extends Repository
{
    const TABLE = 'courses';
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

    public function getAllByStudentId(string $studentId): array
    {
        $sql = ("
            SELECT
                c.*
            FROM
                course_student AS cs
                JOIN courses AS c ON cs.course_id = c.course_id
            WHERE
                cs.student_id = :studentid
        ");
        $params = [':studentid' => $studentId];

        return $this->db->select($sql, $params);
    }
}
