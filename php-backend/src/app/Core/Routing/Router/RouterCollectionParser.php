<?php

namespace App\Core\Routing\Router;

use FastRoute\RouteCollector;

trait RouterCollectionParser
{
    public function debug()
    {
        return $this->routeCollection;
    }

    protected function parseCollection(array $routes): callable
    {
        return function(RouteCollector $r) use (&$routes): void {

            foreach ($routes as $route) {

                $method = $route->method();
                $path = $route->path();

                $handlers = [
                    'handler' => $route->handler(),
                    'middleware' => $route->middleware(),
                ];

                $r->addRoute($method, $path, $handlers);
            }

            // TODO: Move
            // Allows CORS OPTIONS requests
            $r->addRoute('options', '/[{anything}]', 'appAllowOptionsRequest');

        };
    }
}
