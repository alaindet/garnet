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

        if ($body === null || !$validator->validate()) {
            $email = $body['email'] ?? '%STUDENT_EMAIL%';
            $courseId = $body['courseId'] ?? '%COURSE_ID%';
            $msg = "Could not invite student {$email} to join course #{$courseId}";
            $data = ['validation' => $validator->getErrors()];
            throw (new BadRequestHttpException($msg))->setData($data);
        }

        $dto = new CreateStudentInviteDto();
        $dto->email = $body['email'];
        $dto->courseId = $body['courseId'];

        $req->setValidatedData(['dto' => $dto]);

        return $res;
    }
}
