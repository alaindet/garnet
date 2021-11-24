<?php

namespace App\Features\Users\Middleware;

use App\Core\Exceptions\Http\BadRequestHttpException;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;
use App\Core\Middleware;
use App\Features\Users\Constants\UserConstants;
use App\Features\Users\Dtos\AcceptInviteBySigningInDto;
use App\Shared\Validation\Validator;

class AcceptInviteBySigninInValidationMiddleware extends Middleware
{
    const TIMING = self::RUN_BEFORE;

    public function process(Request $req, Response $res, ...$args): Response
    {
        $body = $req->getBody();

        $length = UserConstants::INVITE_TOKEN_LENGTH;

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
            'token' => [
                'required' => true,
                'is' => 'string',
                'exactLength' => $length,
            ],
        ]);

        if ($body === null || !$validator->validate()) {
            $message = 'Invalid request';
            $data = ['validation' => $validator->getErrors()];
            throw (new BadRequestHttpException($message))->setData($data);
        }

        $dto = new AcceptInviteBySigningInDto();
        $dto->email = $body['email'];
        $dto->password = $body['password'];
        $dto->token = $body['token'];

        $req->setValidatedData(['dto' => $dto]);

        return $res;
    }
}
