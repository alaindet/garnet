<?php

namespace App\Features\Authentication\Middleware;

use App\Core\Exceptions\Http\BadRequestHttpException;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;
use App\Core\Middleware;
use App\Features\Authentication\Dtos\SignInUserDto;
use App\Shared\Validation\Validator;


class SignInValidationMiddleware extends Middleware
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
            'password' => [
                'required' => true,
                'is' => 'string',
                'minLength' => 2,
            ],
        ]);

        if ($body === null || !$validator->validate()) {
            $message = 'Wrong email and/or password';
            throw new BadRequestHttpException($message);
        }

        $dto = new SignInUserDto();
        $dto->email = $body['email'];
        $dto->password = $body['password'];

        $req->setDto($dto);

        return $res;
    }
}
