<?php

namespace App\Features\Tasks\Repositories;

trait TasksRepositoryWithProgress
{
    public function getProgressByStudent(string | int $courseId): array
    {
        $sql = "
            SELECT
                u.user_id,
                u.first_name,
                u.last_name,
                SUM(CASE WHEN task_state_id = 1 then 1 ELSE 0 END) AS to_do,
                SUM(CASE WHEN task_state_id = 2 then 1 ELSE 0 END) AS in_progress,
                SUM(CASE WHEN task_state_id = 3 then 1 ELSE 0 END) AS done
            FROM
                {$this->table} AS t
                INNER JOIN task_user AS tu ON t.task_id = tu.task_id
                INNER JOIN users AS u ON tu.user_id = u.user_id
            WHERE t.course_id = :courseid
            GROUP BY tu.user_id
            ORDER BY tu.user_id ASC
        ";
        $params = [':courseid' => $courseId];
        return $this->db->select($sql, $params);
    }

    public function getProgressByTask(string | int $courseId): array
    {
        $sql = "
            SELECT
                t.task_id,
                t.name,
                t.description,
                SUM(CASE WHEN task_state_id = 1 then 1 ELSE 0 END) AS to_do,
                SUM(CASE WHEN task_state_id = 2 then 1 ELSE 0 END) AS in_progress,
                SUM(CASE WHEN task_state_id = 3 then 1 ELSE 0 END) AS done
            FROM
                {$this->table} AS t
                INNER JOIN task_user AS tu ON t.task_id = tu.task_id
            WHERE t.course_id = :courseid
            GROUP BY t.task_id
            ORDER BY t.task_id ASC
        ";
        $params = [':courseid' => $courseId];
        return $this->db->select($sql, $params);
    }
}