<?php

namespace App\Features\Courses\Middleware;

use App\Core\Exceptions\Http\BadRequestHttpException;
use App\Core\Middleware;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;
use App\Shared\Validation\Validator;
use App\Features\Courses\Dtos\UpdateCourseDto;

class UpdateCourseValidationMiddleware extends Middleware
{
    const TIMING = self::RUN_BEFORE;

    public function process(Request $req, Response $res, ...$args): Response
    {
        $body = $req->getBody();
        $courseId = $req->getUriParameter('courseid');

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

        if ($body === null || $courseId === null || !$validator->validate()) {
            $message = 'Invalid data';
            $data = ['validation' => $validator->getErrors()];
            throw (new BadRequestHttpException($message))->setData($data);
        }

        $dto = new UpdateCourseDto();
        $dto->courseId = $courseId;
        $dto->name = $body['name'];
        $dto->description = $body['description'] ?? null;

        $req->setValidatedData(['dto' => $dto]);

        return $res;
    }
}
