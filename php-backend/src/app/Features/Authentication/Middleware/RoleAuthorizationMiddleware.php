<?php

namespace App\Features\Authentication\Middleware;

use App\Core\Middleware;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;
use App\Core\Exceptions\Http\ForbiddenHttpException;

class RoleAuthorizationMiddleware extends Middleware
{
    const TIMING = self::RUN_BEFORE;

    public function process(Request $req, Response $res, ...$args): Response
    {
        $requiredRole = $args[0];

        $authData = $req->getAuthenticationData();

        if (
            $authData === null ||
            !isset($authData['user_role_id']) ||
            $authData['user_role_id'] !== $requiredRole
        ) {
            throw new ForbiddenHttpException('You are not authorized');
        }

        return $res;
    }
}
