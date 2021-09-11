<?php

namespace App\Features\Courses\Repositories;

use App\Features\Courses\Dtos\CreateCourseDto;
use App\Shared\Utils\Time;

trait CoursesRepositoryWriteOperations
{
    public function create(CreateCourseDto $dto): array
    {
        $now = Time::getDate();

        $sql = "
            INSERT INTO {$this->table}
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

    public function updateById(string|int $courseId, array $fields): int
    {
        $updates = [
            'updated_on = :updatedon',
        ];

        $params = [
            ':courseid' => $courseId,
            ':updatedon' => Time::getDate(),
        ];

        foreach ($fields as $field => $value) {
            $placeholder = ":{$field}";
            $params[$placeholder] = $value;
            $updates[] = "{$field} = {$placeholder}";
        }

        $setClause = implode(', ', $updates);

        $sql = "UPDATE {$this->table} SET {$setClause} WHERE course_id = :courseid";

        return $this->db->execute($sql, $params);
    }

    public function deleteById(string|int $courseId): int
    {
        $sql = "DELETE FROM {$this->table} WHERE course_id = :courseid";
        $params = [':courseid' => $courseId];
        return $this->db->execute($sql, $params);
    }
}