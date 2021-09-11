<?php

namespace App\Features\Board\Services;

use App\Features\Board\Models\BoardTask;
use App\Features\Tasks\Repositories\TasksRepository;
use App\Features\Board\Dtos\GetBoardTasksRequest;
use App\Features\Board\Dtos\GetBoardTasksResponse;
use App\Features\Board\Dtos\UpdateTaskState;
use App\Features\Board\Dtos\GetProgressByStudent;
use App\Features\Board\Dtos\GetProgressByTask;
use App\Features\Board\Models\StudentProgress;
use App\Features\Board\Models\TaskProgress;

class BoardService
{
    private TasksRepository $tasksRepo;

    public function __construct()
    {
        $this->tasksRepo = new TasksRepository();
    }

    public function getTasksByBoard(
        GetBoardTasksRequest $dtoIn,
    ): GetBoardTasksResponse
    {
        $data = $this->tasksRepo->getAllByCourseIdAndUserId($dtoIn);

        $parsedData = [];

        foreach ($data as $item) {
            $task = new BoardTask();
            $task->taskId = $item['task_id'];
            $task->taskStateId = $item['task_state_id'];
            $task->createdOn = $item['created_on'];
            $task->updatedOn = $item['updated_on'];
            $task->name = $item['name'];
            $task->description = $item['description'];
            $parsedData[] = $task;
        }

        return new GetBoardTasksResponse(...$parsedData);
    }

    public function updateTaskState(UpdateTaskState $dto): bool
    {
        return $this->tasksRepo->updateStateByIdAndUserId($dto);
    }

    public function getProgressByStudent(string|int $courseId): GetProgressByStudent
    {
        $data = $this->tasksRepo->getProgressByStudent($courseId);
        $parsedData = [];

        foreach ($data as $item) {
            $progress = new StudentProgress();
            $progress->userId = $item['user_id'];
            $progress->firstName = $item['first_name'];
            $progress->lastName = $item['last_name'];
            $progress->tasksToDo = (int) $item['to_do'];
            $progress->tasksInProgress = (int) $item['in_progress'];
            $progress->tasksDone = (int) $item['done'];
            $parsedData[] = $progress;
        }

        return new GetProgressByStudent(...$parsedData);    
    }

    public function getProgressByTask(string|int $courseId): GetProgressByTask
    {
        $data = $this->tasksRepo->getProgressByTask($courseId);
        $parsedData = [];

        foreach ($data as $item) {
            $progress = new TaskProgress();
            $progress->taskId = $item['task_id'];
            $progress->taskName = $item['name'];
            $progress->taskDescription = $item['description'];
            $progress->studentsToDo = $item['to_do'];
            $progress->studentsInProgress = $item['in_progress'];
            $progress->studentsDone = $item['done'];
            $parsedData[] = $progress;
        }

        return new GetProgressByTask(...$parsedData);
    }

    public function doTeacherAndStudentBelongToCourse(
        string|int $teacherId,
        string|int $studentId,
        string|int $courseId,
    ): bool
    {

    }
}
