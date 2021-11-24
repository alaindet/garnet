<?php

namespace App\Core\Http\RequestFactory\ServerRequest;

use App\Core\Services\Configuration\Configuration;

trait ServerRequestPathParser
{
    protected static function getPath(): string
    {
        $uri = $_SERVER['REQUEST_URI'];

        // Strip query string
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        // Decode percentages from URL
        return rawurldecode($uri);
    }
}
