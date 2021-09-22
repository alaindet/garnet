<?php

namespace App\Features\Tasks\Repositories;

use App\Core\Repository;
use App\Core\Services\Database\Database;
use App\Features\Board\Dtos\GetBoardTasksRequestDto;
use App\Features\Tasks\Dtos\CreateTaskDto;
use App\Features\Board\Dtos\UpdateTaskStateDto;
use App\Shared\Utils\Time;

class TasksRepository extends Repository
{
    use TasksRepositoryWithProgress;

    const TABLE = 'tasks';
    protected string $table;
    protected Database $db;

    public function __construct()
    {
        $this->table = self::TABLE;
        $this->db = appServiceProvider(Database::class);
    }

    public function getAllByCourseId(string|int $courseId): array
    {
        $sql = "SELECT * FROM {$this->table} WHERE course_id = :courseid";
        $params = [ ':courseid' => $courseId ];
        return $this->db->select($sql, $params);
    }

    public function getAllByCourseIdAndUserId(GetBoardTasksRequestDto $dto): array
    {
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
                INNER JOIN {$this->table} AS t ON tu.task_id = t.task_id
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

    public function findById(string|int $taskId): array|null
    {
        $sql = "SELECT * FROM {$this->table} WHERE task_id = :taskid";
        $params = [':taskid' => $taskId];
        return $this->db->selectFirst($sql, $params);
    }

    public function create(CreateTaskDto $dto): array
    {
        $now = Time::getDate();

        $sql = "
          INSERT INTO {$this->table}
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

    public function updateById(string|int $taskId, array $fields): int
    {
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

        $sql = "UPDATE {$this->table} SET {$setClause} WHERE task_id = :taskid";

        return $this->db->execute($sql, $params);
    }

    public function updateStateByIdAndUserId(UpdateTaskStateDto $dto): bool
    {
        $sql = "
            UPDATE task_user
            SET task_state_id = :taskstateid
            WHERE task_id = :taskid AND user_id = :userid
        ";

        $params = [
            ':taskstateid' => $dto->taskStateId,
            ':taskid' => $dto->taskId,
            ':userid' => $dto->userId,
        ];

        $this->db->execute($sql, $params);

        return true;
    }

    public function deleteById(string|int $taskId): int
    {
        $sql = "DELETE FROM {$this->table} WHERE task_id = :taskid";
        $params = [':taskid' => $taskId];
        return $this->db->execute($sql, $params);
    }

    public function cloneStudentTasksFromCourse(
        string | int $courseId,
        string | int $studentId
    ): void
    {
        $sql = "
            INSERT INTO task_user (task_id, user_id)
            SELECT t.task_id, :studentid
            FROM {$this->table} AS t
            WHERE t.course_id = :courseid
        ";

        $params = [
            ':studentid' => $studentId,
            ':courseid' => $courseId,
        ];

        $this->db->insert($sql, $params);
    }
}
