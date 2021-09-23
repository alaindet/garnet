<?php

namespace App\Features\Users\Middleware;

use App\Core\Exceptions\Http\BadRequestHttpException;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;
use App\Core\Middleware;
use App\Features\Users\Constants\UserConstants;
use App\Features\Users\Dtos\AcceptInviteByRegisteringDto;
use App\Shared\Validation\Validator;

class AcceptInviteByRegistrationValidationMiddleware extends Middleware
{
    const TIMING = self::RUN_BEFORE;

    public function process(Request $req, Response $res, ...$args): Response
    {
        $body = $req->getBody();

        $tokenLength = UserConstants::INVITE_TOKEN_LENGTH;

        $validator = new Validator($body, [
            'email' => [
                'required' => true,
                'is' => 'string',
                'email' => true,
            ],
            'password' => [
                'required' => true,
                'is' => 'string',
            ],
            'firstName' => [
                'required' => true,
                'is' => 'string',
                'minLength' => 2,
            ],
            'lastName' => [
                'required' => true,
                'is' => 'string',
                'minLength' => 2,
            ],
            'token' => [
                'required' => true,
                'is' => 'string',
                'exactLength' => $tokenLength,
            ],
        ]);

        if (!$validator->validate()) {
            $message = 'Invalid request';
            $data = ['validation' => $validator->getErrors()];
            throw (new BadRequestHttpException($message))->setData($data);
        }

        $dto = new AcceptInviteByRegisteringDto();
        $dto->email = $body['email'];
        $dto->password = $body['password'];
        $dto->firstName = $body['firstName'];
        $dto->lastName = $body['lastName'];
        $dto->token = $body['token'];

        $req->setValidatedData(['dto' => $dto]);

        return $res;
    }
}
