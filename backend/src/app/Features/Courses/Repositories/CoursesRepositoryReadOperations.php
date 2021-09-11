<?php

namespace App\Features\Courses\Repositories;

trait CoursesRepositoryReadOperations
{
    public function getAllByTeacherId(string|int $teacherId): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE teacher_id = :teacherid";
        $params = [':teacherid' => $teacherId];

        return $this->db->select($sql, $params);
    }

    public function getAllByStudentId(string|int $studentId): array
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

    public function findById(string|int $courseId): array|null
    {
        $sql = "SELECT * FROM {$this->table} WHERE course_id = :courseid";
        $params = [':courseid' => $courseId];
        return $this->db->selectFirst($sql, $params);
    }

    public function existsById(string|int $courseId): bool
    {
        $sql = "SELECT course_id FROM {$this->table} WHERE course_id = :courseid";
        $params = [':courseid' => $courseId];
        return $this->db->selectFirst($sql, $params) !== null;
    }

    public function findByName(string $courseName): array|null
    {
        $sql = "SELECT * FROM {$this->table} WHERE name = :coursename";
        $params = [':coursename' => $courseName];
        return $this->db->selectFirst($sql, $params);
    }

    public function getTeacherAndCourse(
        string|int $teacherId,
        string|int $studentId,
        string|int $courseId,
    ): bool
    {
        $sql = "
            SELECT
                cs.course_id,
                cs.student_id,
                c.teacher_id
            FROM
                course_student AS cs
                INNER JOIN courses AS c ON cs.course_id = c.course_id
            WHERE
                cs.course_id = :courseid AND
                cs.student_id = :studentid
        ";

        $params = [
            ':courseid' => $courseId,
            ':studentid' => $studentId,
        ];

        if ($)

        $result = $this->db->selectFirst($sql, $params);
    }
}