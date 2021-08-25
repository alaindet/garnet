<?php

namespace App\Features\Tasks\Services;

use App\Core\Exceptions\Http\InternalServerErrorHttpException;
use App\Core\Exceptions\Http\NotFoundHttpException;
use App\Features\Courses\Services\CoursesService;
use App\Features\Tasks\Repositories\TasksRepository;
use App\Features\Tasks\Dtos\CreateTaskDto;
use App\Features\Tasks\Dtos\CreatedTaskDto;
use App\Features\Tasks\Dtos\UpdateTaskDto;
use App\Features\Tasks\Dtos\UpdatedTaskDto;
use App\Features\Tasks\Dtos\DeletedTaskDto;

class TasksService
{
    private TasksRepository $tasksRepo;

    public function __construct()
    {
        $this->tasksRepo = new TasksRepository();
    }

    public function create(CreateTaskDto $dtoIn)
    {
        $data = $this->tasksRepo->create($dtoIn);

        $dtoOut = new CreatedTaskDto();
        $dtoOut->taskId = $data['task_id'];
        $dtoOut->courseId = $data['course_id'];
        $dtoOut->createdOn = $data['created_on'];
        $dtoOut->updatedOn = $data['updated_on'];
        $dtoOut->name = $data['name'];
        $dtoOut->description = $data['description'];

        return $dtoOut;
    }

    public function getAllByCourseId(string|int $courseId): array
    {
        $this->coursesService = new CoursesService();

        if (!$this->coursesService->existsById($courseId)) {
            throw new NotFoundHttpException(
                "Course with id #{$courseId} does not exist"
            );
        }

        return $this->tasksRepo->getAllByCourseId($courseId);
    }

    public function findById(string|int $taskId): array
    {
        $task = $this->tasksRepo->findById($taskId);

        if ($task === null) {
            $message = "Task with id #{$taskId} does not exist";
            throw new NotFoundHttpException($message);
        }

        return $task;
    }

    public function updateById(UpdateTaskDto $dtoIn): UpdatedTaskDto
    {
        $task = $this->findById($dtoIn->taskId);

        $fields = [];

        if (isset($dtoIn->name)) {
            $fields['name'] = $dtoIn->name;
            $task['name'] = $dtoIn->name;
        }

        if (isset($dtoIn->description)) {
            $fields['description'] = $dtoIn->description;
            $task['description'] = $dtoIn->description;
        }

        $updated = $this->tasksRepo->updateById($dtoIn->taskId, $fields);

        if ($updated === 0) {
            $message = "Could not update task with id #{$dtoIn->taskId}";
            throw new InternalServerErrorHttpException($message);
        }

        $dtoOut = new UpdatedTaskDto();
        $dtoOut->taskId = $task['task_id'];
        $dtoOut->courseId = $task['course_id'];
        $dtoOut->createdOn = $task['created_on'];
        $dtoOut->updatedOn = $task['updated_on'];
        $dtoOut->name = $task['name'];
        $dtoOut->description = $task['description'];

        return $dtoOut;
    }

    public function deleteById(string|int $taskId): DeletedTaskDto
    {
        $task = $this->findById($taskId);

        $deleted = $this->tasksRepo->deleteById($taskId);

        if ($deleted === 0) {
            $message = "Could not update course with id #{$taskId}";
            throw new InternalServerErrorHttpException($message);
        }

        $dtoOut = new DeletedTaskDto();
        $dtoOut->teacherId = $task['task_id'];
        $dtoOut->courseId = $task['course_id'];
        $dtoOut->createdOn = $task['created_on'];
        $dtoOut->updatedOn = $task['updated_on'];
        $dtoOut->name = $task['name'];
        $dtoOut->description = $task['description'];

        return $dtoOut;
    }
}
