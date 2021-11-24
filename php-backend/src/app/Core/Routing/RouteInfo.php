<?php

namespace App\Core\Routing;

class RouteInfo
{
    public int $matchResult;
    public string $handler;
    public array $middleware;
    public array $uriParameters;
}