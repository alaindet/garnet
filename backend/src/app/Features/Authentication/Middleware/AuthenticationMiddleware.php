<?php

namespace App\Features\Authentication\Middleware;

use Firebase\JWT\JWT;

use App\Core\Exceptions\Http\UnauthorizedHttpException;
use App\Core\Middleware;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;
use App\Features\Users\Repositories\UserSessionsRepository;
use App\Shared\Utils\Time;

class AuthenticationMiddleware extends Middleware
{
    const TIMING = self::RUN_BEFORE;

    private UserSessionsRepository $userSessionsRepo;

    public function __construct()
    {
        $this->userSessionsRepo = new UserSessionsRepository();
    }

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
                $this->throwUnauthorized();
            }

            $userSession = $this->userSessionsRepo->getByHash($decoded->sub);

            if ($userSession === null) {
                $this->throwUnauthorized();
            }

            $req->setAuthenticationData([
                'user_id' => $userSession['user_id'],
                'user_role_id' => $userSession['user_role_id'],
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
