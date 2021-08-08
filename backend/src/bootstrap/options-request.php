<?php

/**
 * This allows for a faster response on OPTIONS pre-flight requests
 */
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {

    $config = appConfig();

    $corsOrigin = $config->get('security.cors.origin');
    $corsMethods = $config->get('security.cors.methods');
    $corsMaxAge = $config->get('security.cors.maxage');
    $corsHeaders = $config->get('security.cors.headers');

    http_response_code(204);
    header("Access-Control-Allow-Origin: {$corsOrigin}");
    header("Access-Control-Allow-Methods: {$corsMethods}");
    header("Access-Control-Max-Age: {$corsMaxAge}");
    header("Access-Control-Allow-Headers: {$corsHeaders}");
    exit();
}