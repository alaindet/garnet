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
        $taskStateId = $body['taskStateId'];

        $taskStateIds = TaskState::getValues();

        if (!in_array($taskStateId, $taskStateIds)) {
            $message = 'Please provide a valid task state';
            $data = null;
            throw (new BadRequestHttpException($message))->setData($data);
        }

        $req->setValidatedData([
            'taskStateId' => $taskStateId,
        ]);

        return $res;
    }
}
