<?php

namespace App\Features\Users\Middleware;

use App\Core\Exceptions\Http\BadRequestHttpException;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;
use App\Core\Middleware;
use App\Features\Users\Constants\UserConstants;
use App\Features\Users\Dtos\CheckInviteDto;
use App\Shared\Validation\Validator;

class CheckInviteValidationMiddleware extends Middleware
{
    const TIMING = self::RUN_BEFORE;

    public function process(Request $req, Response $res, ...$args): Response
    {
        $body = $req->getBody();

        $length = UserConstants::INVITE_TOKEN_LENGTH;

        $validator = new Validator($body, [
            'token' => [
                'required' => true,
                'exactLength' => $length,
                'existsOnDatabase' => ['invites', 'token'],
            ],
        ]);

        if (!$validator->validate()) {
            $message = 'Invite token is invalid';
            $data = ['validation' => $validator->getErrors()];
            throw (new BadRequestHttpException($message))->setData($data);
        }

        $dto = new CheckInviteDto();
        $dto->token = $body['token'];

        $req->setValidatedData(['dto' => $dto]);

        return $res;
    }
}
