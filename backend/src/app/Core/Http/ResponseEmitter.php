<?php

namespace App\Core\Http;

use App\Core\Http\Response\Response;

abstract class ResponseEmitter
{
    /**
     * Send JSON by default
     *
     * @param Response $response
     * @return void
     */
    static public function send(Response $response): void
    {
        self::sendJson($response);
    }

    static public function sendJson(Response $response): void
    {
        $jsonFlags = (
            // JSON_PRETTY_PRINT |
            JSON_UNESCAPED_UNICODE |
            JSON_UNESCAPED_SLASHES |
            JSON_PRESERVE_ZERO_FRACTION |
            JSON_THROW_ON_ERROR
        );

        $response->setBody(json_encode($response->getBody(), $jsonFlags));
        $response->setHeader('Content-Type', 'application/json; charset=UTF-8');

        self::sendStatusCode($response);
        self::sendHeaders($response);
        self::sendBody($response);
    }

    static private function sendStatusCode(Response $response): void
    {
        http_response_code($response->getStatusCode());
    }

    static private function sendHeaders(Response $response): void
    {
        foreach ($response->getHeaders() as $name => $value) {
            header("{$name}: {$value}");
        }
    }

    static private function sendBody(Response $response): void
    {
        echo $response->getBody();
    }
}
