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
        $taskId = $req->getUriParameter('taskid');
        $body = $req->getBody();

        $validator = new Validator($body, [
            'name' => [
                'required' => false,
                'minLength' => 5,
            ],
            'description' => [
                'required' => false,
                'minLength' => 5,
            ]
        ]);

        if (!$validator->validate()) {
            $message = 'Invalid data';
            $data = [
                'validation' => $validator->getErrors(),
            ];
            throw (new BadRequestHttpException($message))->setData($data);
        }

        $dto = new UpdateTaskDto();
        $dto->taskId = $taskId;
        $dto->name = $body['name'] ?? null;
        $dto->description = $body['description'] ?? null;

        $req->setValidatedData($dto);

        return $res;
    }
}
