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
        $userId = $authData['user_id'];
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

    public function getStudentsProgress(Request $req, Response $res): Response
    {
        $courseId = $req->getUriParameter('courseid');

        $res->setBody([
            'message' => "Progress of students from course #{$courseId}",
            'data' => $this->boardService->getCourseProgress($courseId),
        ]);

        return $res;
    }
}
