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

    public function getStudentAndTeacherCourseAssociation(
        string|int $studentId,
        string|int $courseId
    ): array|null
    {
        $sql = "
            SELECT
                c.teacher_id,
                cs.student_id,
                cs.course_id
            FROM
                course_student AS cs
                INNER JOIN courses AS c ON cs.course_id = c.course_id
            WHERE
                cs.student_id = :studentid AND
                cs.course_id = :courseid
        ";

        $params = [
            ':studentid' => $studentId,
            ':courseid' => $courseId,
        ];

        return $this->db->selectFirst($sql, $params);
    }

    public function searchByName(string $courseName): array
    {
        $sql = "
            SELECT c.course_id, c.name
            FROM {$this->table} AS c
            WHERE c.name LIKE :coursename
        ";

        $params = [
            ':coursename' => "%{$courseName}%"
        ];

        return $this->db->select($sql, $params);
    }
}
