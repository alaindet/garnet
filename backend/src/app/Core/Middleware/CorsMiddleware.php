<?php

namespace App\Core\Middleware;

use App\Core\Middleware;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;

class CorsMiddleware extends Middleware
{
    const TIMING = self::RUN_BEFORE;

    public function process(Request $req, Response $res, ...$args): Response
    {
        $config = appConfig();

        $corsOrigin = $config->get('security.cors.origin');
        $corsMethods = $config->get('security.cors.methods');
        $corsMaxAge = $config->get('security.cors.maxage');
        $corsHeaders = $config->get('security.cors.headers');

        $res->setHeader('Access-Control-Allow-Origin', $corsOrigin);
        $res->setHeader('Access-Control-Allow-Methods', $corsMethods);
        $res->setHeader('Access-Control-Max-Age', $corsMaxAge);
        $res->setHeader('Access-Control-Allow-Headers', $corsHeaders);

        // $config = appConfig();

        // $corsOrigin = $config->get('security.cors.origin');
        // $res->setHeader('Access-Control-Allow-Origin', $corsOrigin);

        // $corsMethods = $config->get('security.cors.methods');
        // $res->setHeader('Access-Control-Allow-Methods', $corsMethods);

        // $corsHeaders = implode(', ', [
        //     "Content-Type",
        //     "Access-Control-Allow-Headers",
        //     "Authorization",
        //     "X-Requested-With"
        // ]);
        // $res->setHeader('Access-Control-Request-Headers', $corsHeaders);

        return $res;
    }
}
