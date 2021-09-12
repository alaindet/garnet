<?php

namespace App\Features\Courses\Middleware;

use App\Core\Exceptions\Http\BadRequestHttpException;
use App\Core\Middleware;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;
use App\Shared\Validation\Validator;
use App\Features\Courses\Dtos\CreateCourseDto;

class CreateCourseValidationMiddleware extends Middleware
{
    const TIMING = self::RUN_BEFORE;

    public function process(Request $req, Response $res, ...$args): Response
    {
        $body = $req->getBody();

        $validator = new Validator($body, [
            'name' => [
                'required' => true,
                'minLength' => 5,
            ],
            'description' => [
                'required' => false,
                'minLength' => 5,
            ]
        ]);

        if (!$validator->validate()) {
            $message = 'Could not create a new course';
            $data = [
                'validation' => $validator->getErrors(),
            ];
            throw (new BadRequestHttpException($message))->setData($data);
        }

        $authData = $req->getAuthenticationData();

        $dto = new CreateCourseDto();
        $dto->teacherId = $authData['user_id'];
        $dto->name = $body['name'];
        $dto->description = $body['description'] ?? null;

        $req->setValidatedData(['dto' => $dto]);

        return $res;
    }
}
