<?php

namespace App\Core\Routing\Route;

use App\Core\Http\HttpMethod;

trait RouteHttpMethodsHelpers
{
    public static function get(?string $path, ?string $handler): Route
    {
        return new Route(HttpMethod::Get, $path, $handler);
    }

    public static function post(?string $path, ?string $handler): Route
    {
        return new Route(HttpMethod::Post, $path, $handler);
    }

    public static function put(?string $path, ?string $handler): Route
    {
        return new Route(HttpMethod::Put, $path, $handler);
    }

    public static function patch(?string $path, ?string $handler): Route
    {
        return new Route(HttpMethod::Patch, $path, $handler);
    }

    public static function delete(?string $path, ?string $handler): Route
    {
        return new Route(HttpMethod::Delete, $path, $handler);
    }

    public static function options(?string $path, ?string $handler): Route
    {
        return new Route(HttpMethod::Options, $path, $handler);
    }
}
