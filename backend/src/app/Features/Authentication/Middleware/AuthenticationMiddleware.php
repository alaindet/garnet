<?php

namespace App\Features\Authentication\Middleware;

use Firebase\JWT\JWT;

use App\Core\Exceptions\Http\UnauthorizedHttpException;
use App\Core\Middleware;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;

class AuthenticationMiddleware extends Middleware
{
    const TIMING = self::RUN_BEFORE;

    public function process(Request $req, Response $res, ...$args): Response
    {
        if (!$req->hasHeader('Authorization')) {
            $message = 'You are not authorized';
            throw new UnauthorizedHttpException($message);
        }

        try {
            $authHeader = $req->getHeaderLine('Authorization');
            [$bearer, $jwt] = explode(' ', $authHeader);
            $secret = appConfig('security.jwt.secret');
            $decoded = JWT::decode($jwt, $secret, ['HS256']);
            $req->setAuthenticationData($decoded);
            return $res;
        }

        catch (\Exception $e) {
            $message = 'You are not authorized';
            throw new UnauthorizedHttpException($message);
        }
    }
}
