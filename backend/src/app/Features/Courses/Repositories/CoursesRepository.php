<?php

namespace App\Features\Courses\Repositories;

use App\Core\Repository;
use App\Core\Services\Database\Database;
use App\Features\Courses\Dtos\CreateCourseDto;
use App\Shared\Utils\Time;

class CoursesRepository extends Repository
{
    const TABLE = 'courses';
    protected Database $db;

    public function __construct()
    {
        $this->db = appServiceProvider(Database::class);
    }

    public function create(CreateCourseDto $dto): array
    {
        $now = Time::getDate();
        $table = self::TABLE;

        $sql = "
            INSERT INTO {$table}
                (teacher_id, created_on, updated_on, name, description)
            VALUES
                (:teacherid, :createdon, :updatedon, :name, :description)
        ";

        $params = [
            ':teacherid' => $dto->teacherId,
            ':createdon' => $now,
            ':updatedon' => $now,
            ':name' => $dto->name,
            ':description' => $dto->description,
        ];

        $courseId = $this->db->insert($sql, $params);

        return [
            'course_id' => $courseId,
            'teacher_id' => $dto->teacherId,
            'created_on' => $now,
            'updated_on' => $now,
            'name' => $dto->name,
            'description' => $dto->description,
        ];
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
