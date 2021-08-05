<?php

namespace App\Core\Routing;

use App\Core\Common\GetterSetter;

class RouteGroup
{
    use GetterSetter;

    private string $_path = '';
    private string $_handler = '';
    private $_middleware = [];
    private $_pathConstraints = [];
    private $_routes = [];

    public function path(?string $path = null)
    {
        return $this->getOrSet('_path', $path);
    }

    public function handler(?string $handler = null)
    {
        return $this->getOrSet('_handler', $handler);
    }

    public function middleware(?array $middleware = null)
    {
        return $this->getOrSet('_middleware', $middleware);
    }

    public function pathConstraints(?array $pathConstraints = null)
    {
        return $this->getOrSet('_pathConstraints', $pathConstraints);
    }

    public function routes(?array $routes = null)
    {
        return $this->getOrSet('_routes', $routes);
    }

    public function collect(): array
    {
        $routes = [];

        foreach ($this->_routes as $route) {
            $route->path($this->_path . $route->path());
            $route->handler($this->_handler . $route->handler());
            $route->middleware(
                array_merge($this->_middleware, $route->middleware())
            );
            $route->pathConstraints(
                array_merge($this->_pathConstraints, $route->pathConstraints())
            );
            $routes[] = $route;
        }

        return $routes;
    }
}
