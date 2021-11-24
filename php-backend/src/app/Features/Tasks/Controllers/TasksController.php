<?php

namespace App\Features\Tasks\Controllers;

use App\Core\Controller;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;
use App\Features\Tasks\Services\TasksService;

class TasksController extends Controller
{
    private TasksService $tasksService;

    public function __construct()
    {
        $this->tasksService = new TasksService();
    }

    public function create(Request $req, Response $res): Response
    {
        $courseId = $req->getUriParameter('courseid');

        $dtoIn = $req->getValidatedData('dto');
        $dtoOut = $this->tasksService->create($dtoIn);

        $res->setBody([
            'message' => "Task \"{$dtoIn->name}\" created for course {$courseId}",
            'data' => $dtoOut,
        ]);

        return $res;
    }

    public function getAll(Request $req, Response $res): Response
    {
        $courseId = $req->getUriParameter('courseid');
        $tasks = $this->tasksService->getAllByCourseId($courseId);

        $res->setBody([
            'message' => "All tasks of course #{$courseId}",
            'data' => $tasks,
        ]);

        return $res;
    }

    public function getById(Request $req, Response $res): Response
    {
        $taskId = $req->getUriParameter('taskid');

        $task = $this->tasksService->findById($taskId);

        $res->setBody([
            'message' => "Get task #{$taskId} data",
            'data' => $task,
        ]);

        return $res;
    }

    public function update(Request $req, Response $res): Response
    {
        $dtoIn = $req->getValidatedData('dto');

        $dtoOut = $this->tasksService->updateById($dtoIn);

        $res->setBody([
            'message' => "Course #{$dtoOut->courseId} updated",
            'data' => $dtoOut,
        ]);

        return $res;
    }

    public function delete(Request $req, Response $res): Response
    {
        $taskId = $req->getUriParameter('taskid');

        $dtoOut = $this->tasksService->deleteById($taskId);

        $res->setBody([
            'message' => "Task #{$taskId} deleted",
            'data' => $dtoOut,
        ]);

        return $res;
    }
}
