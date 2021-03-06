<?php

namespace App\Features\Tasks\Middleware;

use App\Core\Exceptions\Http\BadRequestHttpException;
use App\Core\Middleware;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;
use App\Shared\Validation\Validator;
use App\Features\Tasks\Dtos\CreateTaskDto;

class CreateTaskValidationMiddleware extends Middleware
{
    const TIMING = self::RUN_BEFORE;

    public function process(Request $req, Response $res, ...$args): Response
    {
        $body = $req->getBody();
        $courseId = $req->getUriParameter('courseid');

        $validator = new Validator($body, [
            'name' => [
                'required' => true,
                'is' => 'string',
                'minLength' => 5,
            ],
            'description' => [
                'required' => false,
                'is' => 'string',
                'minLength' => 5,
            ]
        ]);

        if ($body === null || $courseId === null || !$validator->validate()) {
            $courseId = $courseId ?? '%COURSE_ID%';
            $message = "Could not create a new task for course {$courseId}";
            $data = ['validation' => $validator->getErrors()];
            throw (new BadRequestHttpException($message))->setData($data);
        }

        $dto = new CreateTaskDto();
        $dto->courseId = $courseId;
        $dto->name = $body['name'];
        $dto->description = $body['description'] ?? null;

        $req->setValidatedData(['dto' => $dto]);

        return $res;
    }
}
