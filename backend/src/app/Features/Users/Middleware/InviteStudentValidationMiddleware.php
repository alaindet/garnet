<?php

namespace App\Features\Users\Middleware;

use App\Core\Exceptions\Http\BadRequestHttpException;
use App\Core\Middleware;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;
use App\Shared\Validation\Validator;
use App\Features\Users\Dtos\CreateStudentInviteDto;

class InviteStudentValidationMiddleware extends Middleware
{
    const TIMING = self::RUN_BEFORE;

    public function process(Request $req, Response $res, ...$args): Response
    {
        $body = $req->getBody();

        $validator = new Validator($body, [
            'email' => [
                'required' => true,
                'is' => 'string',
                'email' => true,
            ],
            'courseId' => [
                'required' => true,
                'is' => ['string', 'integer'],
                'existsOnDatabase' => ['courses', 'course_id'],
            ],
        ]);

        if (!$validator->validate()) {
            $message = (
                "Could not invite student {$body['email']} ".
                "to join course #{$body['courseId']}"
            );
            $data = [
                'validation' => $validator->getErrors(),
            ];
            throw (new BadRequestHttpException($message))->setData($data);
        }

        $dto = new CreateStudentInviteDto();
        $dto->email = $body['email'];
        $dto->courseId = $body['courseId'];

        $req->setValidatedData(['dto' => $dto]);

        return $res;
    }
}
