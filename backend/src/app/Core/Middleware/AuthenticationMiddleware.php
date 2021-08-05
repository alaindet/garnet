<?php

namespace App\Core\Middleware;

use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;

class AuthenticationMiddleware extends Middleware
{
    const TIMING = self::RUN_BEFORE;

    public function process(Request $req, Response $res, ...$args): Response
    {
        $roles = $args;

        // ...

        return $res;
    }
}
