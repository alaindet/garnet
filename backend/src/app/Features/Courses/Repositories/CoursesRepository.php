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
        $table = self::TABLE;
        $sql = "SELECT * FROM {$table} WHERE teacher_id = :teacherid";
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

    public function findById(string $courseId): array|null
    {
        $table = self::TABLE;
        $sql = "SELECT * FROM {$table} WHERE course_id = :courseid";
        $params = [':courseid' => $courseId];
        return $this->db->selectFirst($sql, $params);
    }

    public function findByName(string $courseName): array|null
    {
        $table = self::TABLE;
        $sql = "SELECT * FROM {$table} WHERE name = :coursename";
        $params = [':coursename' => $courseName];
        return $this->db->selectFirst($sql, $params);
    }

    public function updateById(string $id, array $fields): int
    {
        $table = self::TABLE;

        $updates = [
            'updated_on = :updatedon',
        ];

        $params = [
            ':courseid' => $id,
            ':updatedon' => Time::getDate(),
        ];

        foreach ($fields as $field => $value) {
            $placeholder = ":{$field}";
            $params[$placeholder] = $value;
            $updates[] = "{$field} = {$placeholder}";
        }

        $setClause = implode(', ', $updates);

        $sql = "UPDATE {$table} SET {$setClause} WHERE course_id = :courseid";

        return $this->db->execute($sql, $params);
    }

    public function deleteById(string $id): int
    {
        $table = self::TABLE;
        $sql = "DELETE FROM {$table} WHERE course_id = :courseid";
        $params = [':courseid' => $id];
        return $this->db->execute($sql, $params);
    }
}
