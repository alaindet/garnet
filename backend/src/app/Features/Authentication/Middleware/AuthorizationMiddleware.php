<?php

namespace App\Features\Authentication\Middleware;

use App\Core\Middleware;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;

class AuthorizationMiddleware extends Middleware
{
    const TIMING = self::RUN_BEFORE;

    public function process(Request $req, Response $res, ...$args): Response
    {
        // TODO...

        return $res;
    }
}
