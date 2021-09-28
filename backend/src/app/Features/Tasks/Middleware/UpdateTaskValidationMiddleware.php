<?php

namespace App\Features\Tasks\Middleware;

use App\Core\Exceptions\Http\BadRequestHttpException;
use App\Core\Middleware;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;
use App\Shared\Validation\Validator;
use App\Features\Tasks\Dtos\UpdateTaskDto;

class UpdateTaskValidationMiddleware extends Middleware
{
    const TIMING = self::RUN_BEFORE;

    public function process(Request $req, Response $res, ...$args): Response
    {
        $body = $req->getBody();
        $taskId = $req->getUriParameter('taskid');

        $validator = new Validator($body, [
            'name' => [
                'required' => false,
                'is' => 'string',
                'minLength' => 5,
            ],
            'description' => [
                'required' => false,
                'is' => 'string',
                'minLength' => 5,
            ]
        ]);

        if ($body === null || $taskId === null || !$validator->validate()) {
            $message = 'Invalid data';
            $data = ['validation' => $validator->getErrors()];
            throw (new BadRequestHttpException($message))->setData($data);
        }

        $dto = new UpdateTaskDto();
        $dto->taskId = $taskId;
        $dto->name = $body['name'] ?? null;
        $dto->description = $body['description'] ?? null;

        $req->setValidatedData(['dto' => $dto]);

        return $res;
    }
}
