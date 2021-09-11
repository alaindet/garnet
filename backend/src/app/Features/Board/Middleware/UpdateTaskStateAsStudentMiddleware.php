<?php

namespace App\Features\Board\Middleware;

use App\Core\Exceptions\Http\BadRequestHttpException;
use App\Core\Middleware;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;
use App\Features\Board\Enums\TaskState;

class UpdateTaskStateAsStudentMiddleware extends Middleware
{
    const TIMING = self::RUN_BEFORE;

    public function process(Request $req, Response $res, ...$args): Response
    {
        $studentId = $req->getUriParameter('studentid');

        $req->setValidatedData([
            'studentId' => $studentId,
        ]);

        return $res;
    }
}
