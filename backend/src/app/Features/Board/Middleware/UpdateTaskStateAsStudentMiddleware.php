<?php

namespace App\Features\Board\Middleware;

use App\Core\Exceptions\Http\BadRequestHttpException;
use App\Core\Middleware;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;
use App\Features\Board\Services\BoardService;

class UpdateTaskStateAsStudentMiddleware extends Middleware
{
    const TIMING = self::RUN_BEFORE;

    private BoardService $boardService;

    public function __construct()
    {
        $this->boardService = new BoardService();
    }

    public function process(Request $req, Response $res, ...$args): Response
    {
        $teacherId = $req->getAuthenticationData('user_id');
        $studentId = $req->getUriParameter('studentid');
        $courseId = $req->getUriParameter('courseid');
        $taskId = $req->getUriParameter('courseid');

        if (!$this->boardService->doTeacherAndStudentBelongToCourse(
            $teacherId,
            $studentId,
            $courseId
        )) {
            throw new BadRequestHttpException(
                "Could not update task {$taskId} of course {$courseId} " .
                "by teacher {$teacherId} as student {$studentId}"
            );
        }

        $req->addValidatedData([
            'studentId' => $studentId,
            'taskId' => $taskId,
        ]);

        return $res;
    }
}
