<?php

namespace App\Features\Users\Middleware;

use App\Core\Exceptions\Http\BadRequestHttpException;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;
use App\Core\Middleware;
use App\Features\Users\Constants\UserConstants;
use App\Features\Users\Dtos\AcceptInviteBySignInDto;
use App\Shared\Validation\Validator;

class AcceptInviteBySignInValidationMiddleware extends Middleware
{
    const TIMING = self::RUN_BEFORE;

    public function process(Request $req, Response $res, ...$args): Response
    {
        $body = $req->getBody();

        $length = UserConstants::INVITE_TOKEN_LENGTH;

        $validator = new Validator($body, [
            'email' => [
                'required' => true,
                'email' => true,
            ],
            'password' => [
                'required' => true,
            ],
            'token' => [
                'required' => true,
                'exactLength' => $length,
            ],
        ]);

        if (!$validator->validate()) {
            $message = 'Could not accept invite';
            $data = ['validation' => $validator->getErrors()];
            throw (new BadRequestHttpException($message))->setData($data);
        }

        $dto = new AcceptInviteBySignInDto();
        $dto->email = $body['email'];
        $dto->password = $body['password'];
        $dto->token = $body['token'];

        $req->setValidatedData(['dto' => $dto]);

        return $res;
    }
}
