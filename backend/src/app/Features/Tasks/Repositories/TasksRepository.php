<?php

namespace App\Features\Tasks\Repositories;

use App\Core\Repository;
use App\Core\Services\Database\Database;
use App\Features\Tasks\Dtos\CreateTaskDto;
use App\Features\Board\Dtos\GetBoardTasksRequest;
use App\Shared\Utils\Time;

class TasksRepository extends Repository
{
    const TABLE = 'tasks';
    protected Database $db;

    public function __construct()
    {
        $this->db = appServiceProvider(Database::class);
    }

    public function getAllByCourseId(string|int $courseId): array
    {
        $table = self::TABLE;
        $sql = "SELECT * FROM {$table} WHERE course_id = :courseid";
        $params = [ ':courseid' => $courseId ];
        return $this->db->select($sql, $params);
    }

    public function getAllByCourseIdAndUserId(GetBoardTasksRequest $dto): array {

        $table = self::TABLE;

        $sql = "
            SELECT
                t.task_id,
                tu.task_state_id,
                t.created_on,
                t.updated_on,
                t.name,
                t.description
            FROM
                task_user AS tu
                INNER JOIN {$table} AS t ON tu.task_id = t.task_id
            WHERE
                tu.user_id = :userid AND
                t.course_id = :courseid
        ";

        $params = [
            ':userid' => $dto->userId,
            ':courseid' => $dto->courseId,
        ];

        return $this->db->select($sql, $params);
    }

    public function create(CreateTaskDto $dto): array
    {
        $now = Time::getDate();
        $table = self::TABLE;

        $sql = "
            INSERT INTO {$table}
                (course_id, created_on, updated_on, name, description)
            VALUE
                (:courseid, :createdon, :updatedon, :name, :description)
        ";

        $params = [
            ':courseid' => $dto->courseId,
            ':createdon' => $now,
            ':updatedon' => $now,
            ':name' => $dto->name,
            ':description' => $dto->description,
        ];

        $taskId = $this->db->insert($sql, $params);

        return [
            'task_id' => $taskId,
            'course_id' => $dto->courseId,
            'created_on' => $now,
            'updated_on' => $now,
            'name' => $dto->name,
            'description' => $dto->description,
        ];
    }

    public function findById(string|int $taskId): array|null
    {
        $table = self::TABLE;
        $sql = "SELECT * FROM {$table} WHERE task_id = :taskid";
        $params = [':taskid' => $taskId];
        return $this->db->selectFirst($sql, $params);
    }

    public function updateById(string|int $taskId, array $fields): int
    {
        $table = self::TABLE;

        $updates = [
            'updated_on = :updatedon',
        ];

        $params = [
            ':taskid' => $taskId,
            ':updatedon' => Time::getDate(),
        ];

        foreach ($fields as $field => $value) {
            $placeholder = ":{$field}";
            $params[$placeholder] = $value;
            $updates[] = "{$field} = {$placeholder}";
        }

        $setClause = implode(', ', $updates);

        $sql = "UPDATE {$table} SET {$setClause} WHERE task_id = :taskid";

        return $this->db->execute($sql, $params);
    }

    public function deleteById(string|int $taskId): int
    {
        $table = self::TABLE;
        $sql = "DELETE FROM {$table} WHERE task_id = :taskid";
        $params = [':taskid' => $taskId];
        return $this->db->execute($sql, $params);
    }
}
