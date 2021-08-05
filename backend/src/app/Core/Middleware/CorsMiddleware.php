<?php

namespace App\Core\Middleware;

use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;

class CorsMiddleware extends Middleware
{
    const TIMING = self::RUN_BEFORE;

    public function process(Request $req, Response $res, ...$args): Response
    {
        $origin = appConfig('cors.origin');

        $res->setHeader('Access-Control-Allow-Origin', $origin);

        return $res;
    }
}
