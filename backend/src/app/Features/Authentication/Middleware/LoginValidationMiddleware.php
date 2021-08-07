<?php

namespace App\Features\Authentication\Middleware;

use App\Core\Exceptions\Http\BadRequestHttpException;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;
use App\Core\Middleware;
use App\Features\Authentication\Dtos\LoginUserDto;

class LoginValidationMiddleware extends Middleware
{
    const TIMING = self::RUN_BEFORE;

    public function process(Request $req, Response $res, ...$args): Response
    {
        $body = $req->getBody();

        if (!isset($body['email']) || !isset($body['password'])) {
            $message = 'Missing email and/or password';
            throw new BadRequestHttpException($message);
        }

        if (!filter_var($body['email'], FILTER_VALIDATE_EMAIL)) {
            $message = 'Invalid email';
            throw new BadRequestHttpException($message);
        }

        $dto = new LoginUserDto();
        $dto->email = $body['email'];
        $dto->password = $body['password'];

        $req->setDto($dto);

        return $res;
    }
}
