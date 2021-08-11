<?php

use App\Core\Http\Response\Response;

function appResponseWithCors(Response $res): Response
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

    return $res;
}