<?php

namespace App\Core\Routing;

use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;
use App\Core\Http\ResponseFactory;
use App\Core\Middleware;

class Dispatcher
{
    // TODO: Enum?
    const HandlerMethodSeparator = '@';

    private Request $request;
    private RouteInfo $routeInfo;

    public function __construct(Request $request, RouteInfo $routeInfo)
    {
        $this->request = $request;
        $this->routeInfo = $routeInfo;
    }

    /**
     * TODO: Add middlewares
     *
     * @return Response
     */
    public function dispatch(): Response
    {
        [$before, $after] = $this->sortMiddleware($this->routeInfo->middleware);

        $uriParams = $this->routeInfo->uriParameters ?? [];
        $this->request->setUriParameters($uriParams);
        $response = ResponseFactory::createResponse();

        // Execute before middleware
        foreach ($before as $middleware) {
            [$className, $inputs] = $middleware;
            $response = (new $className())->process(
                $this->request,
                $response,
                ...$inputs
            );
        }

        // Handle request
        $handler = $this->routeInfo->handler;
        $separator = self::HandlerMethodSeparator;
        [$controllerClass, $controllerMethod] = explode($separator, $handler);
        $controller = new $controllerClass();
        $response = $controller->$controllerMethod($this->request, $response);

        // Execute after middleware
        foreach ($after as $middleware) {
            [$className, $inputs] = $middleware;
            $response = (new $className())->process(
                $this->request,
                $response,
                ...$inputs
            );
        }

        return $response;
    }

    private function sortMiddleware(array $middlewares): array
    {
        $before = [];
        $after = [];

        foreach ($middlewares as $middleware) {

            \is_array($middleware)
                ? [$className, $inputs] = $middleware
                : [$className, $inputs] = [$middleware, []];
    
            $timing = \constant("{$className}::TIMING");
    
            switch ($timing) {
                case Middleware::RUN_BEFORE:
                    $before[] = [$className, $inputs];
                    break;
                case Middleware::RUN_AFTER:
                    $after[] = [$className, $inputs];
                    break;
            }
        }

        return [$before, $after];
    }
}