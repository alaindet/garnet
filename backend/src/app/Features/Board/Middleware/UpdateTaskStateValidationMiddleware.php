<?php

namespace App\Features\Board\Middleware;

use App\Core\Exceptions\Http\BadRequestHttpException;
use App\Core\Middleware;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;
use App\Features\Board\Enums\TaskState;

class UpdateTaskStateValidationMiddleware extends Middleware
{
    const TIMING = self::RUN_BEFORE;

    public function process(Request $req, Response $res, ...$args): Response
    {
        $body = $req->getBody();
        $taskStateId = $body['taskStateId'] ?? null;
        $taskStateIds = TaskState::getValues();

        if (
            $body === null ||
            $taskStateId === null ||
            !in_array($taskStateId, $taskStateIds)
        ) {
            throw new BadRequestHttpException(
                'Please provide a valid task state'
            );
        }

        $req->addValidatedData([
            'taskStateId' => $taskStateId,
        ]);

        return $res;
    }
}
