<?php

namespace App\Features\Authentication\Middleware;

use Firebase\JWT\JWT;

use App\Core\Exceptions\Http\UnauthorizedHttpException;
use App\Core\Middleware;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;
use App\Shared\Utils\Time;

class AuthenticationMiddleware extends Middleware
{
    const TIMING = self::RUN_BEFORE;

    public function process(Request $req, Response $res, ...$args): Response
    {
        if (!$req->hasHeader('Authorization')) {
            $this->throwUnauthorized();
        }

        try {
            $authHeader = $req->getHeaderLine('Authorization');
            [$bearer, $jwt] = explode(' ', $authHeader);
            $secret = appConfig('security.jwt.secret');
            $decoded = JWT::decode($jwt, $secret, ['HS256']);

            if (Time::getTimestampInSeconds() >= $decoded->exp) {
                $this->throwUnauthorized('Your session has expired');
            }

            $appRole = 'app.role';

            $req->setAuthenticationData([
                'user_id' => $decoded->sub,
                'user_role_id' => $decoded->$appRole,
            ]);

            return $res;
        }

        catch (\Exception $e) {
            $this->throwUnauthorized();
        }
    }

    private function throwUnauthorized(?string $message = null): void
    {
        $message = $message ?? 'You are not authorized';
        throw new UnauthorizedHttpException($message);
    }
}
