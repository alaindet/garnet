<?php

namespace App\Features\Board\Controllers;

use App\Core\Controller;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;
use App\Features\Board\Services\BoardService;
use App\Features\Board\Dtos\GetBoardTasksRequest;
use App\Features\Board\Dtos\UpdateTaskState;

class BoardController extends Controller
{
    private BoardService $boardService;

    public function __construct()
    {
        $this->boardService = new BoardService();
    }

    public function getTasksByBoard(Request $req, Response $res): Response
    {
        $authData = $req->getAuthenticationData();
        $validatedData = $req->getValidatedData();
        $studentId = $validatedData['studentId'];
        $userId = $studentId ?? $authData['user_id'];
        $courseId = $req->getUriParameter('courseid');

        $dto = new GetBoardTasksRequest();
        $dto->courseId = $courseId;
        $dto->userId = $userId;

        $tasksCollection = $this->boardService->getTasksByBoard($dto);

        $res->setBody([
            'message' => "All tasks of user #{$userId} from course #{$courseId}",
            'data' => $tasksCollection->tasks,
        ]);

        return $res;
    }

    public function updateTaskState(Request $req, Response $res): Response
    {
        $auth = $req->getAuthenticationData();
        $body = $req->getValidatedData();

        $userId = $auth['user_id'];
        $taskId = $req->getUriParameter('taskid');
        $taskStateId = $body['taskStateId'];

        $dto = new UpdateTaskState();
        $dto->userId = $userId;
        $dto->taskId = $taskId;
        $dto->taskStateId = $taskStateId;

        $this->boardService->updateTaskState($dto);

        $res->setBody([
            'message' => "Task #{$taskId} of user #{$userId} updated to state #{$taskStateId}",
            'data' => null,
        ]);

        return $res;
    }

    public function getProgressByStudent(Request $req, Response $res): Response
    {
        $courseId = $req->getUriParameter('courseid');

        $res->setBody([
            'message' => "Progress of course #{$courseId} by student",
            'data' => $this->boardService->getProgressByStudent($courseId),
        ]);

        return $res;
    }

    public function getProgressByTask(Request $req, Response $res): Response
    {
        $courseId = $req->getUriParameter('courseid');

        $res->setBody([
            'message' => "Progress of course #{$courseId} by task",
            'data' => $this->boardService->getProgressByTask($courseId),
        ]);

        return $res;
    }
}
