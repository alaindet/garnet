<?php

namespace App\Features\Board\Services;

use App\Features\Board\Models\BoardTask;
use App\Features\Tasks\Repositories\TasksRepository;
use App\Features\Board\Dtos\GetBoardTasksRequest;
use App\Features\Board\Dtos\GetBoardTasksResponse;
use App\Features\Board\Dtos\UpdateTaskState;
use App\Features\Courses\Repositories\CoursesRepository;

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

    public function getCourseProgress(string | int $courseId): array
    {
        $courseRepo = new CoursesRepository();

        return $courseRepo->getProgress($courseId);
    }
}
