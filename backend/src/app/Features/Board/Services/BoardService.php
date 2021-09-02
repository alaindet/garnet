<?php

namespace App\Features\Board\Services;

use App\Core\Exceptions\Http\InternalServerErrorHttpException;
use App\Core\Exceptions\Http\NotFoundHttpException;
use App\Features\Board\Models\BoardTask;
use App\Features\Tasks\Repositories\TasksRepository;
use App\Features\Board\Dtos\GetBoardTasksRequest;
use App\Features\Board\Dtos\GetBoardTasksResponse;

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
            // public string|int $taskId;
            // public string|int $taskStateId;
            // public string $createdOn;
            // public string $updatedOn;
            // public string $name;
            // public string $description;
            // ...
        }


        $dtoOut = new GetBoardTasksResponse(...$parsedData);

        return $dtoOut;
    }
}
