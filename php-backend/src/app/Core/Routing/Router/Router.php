<?php

namespace App\Core\Routing\Router;

use FastRoute\Dispatcher;
use function FastRoute\simpleDispatcher;
use function FastRoute\cachedDispatcher;

use App\Core\Exceptions\Http\NotFoundHttpException;
use App\Core\Exceptions\Http\MethodNotAllowedHttpException;
use App\Core\Routing\RouteInfo;
use App\Core\Services\Configuration\Configuration;
use App\Core\Http\Request\Request;

class Router
{
    use RouterCollectionParser;

    private $routeCollection;

    public function __construct($routeCollection)
    {
        $this->routeCollection = $this->parseCollection($routeCollection);
    }

    public function match(Request $request): RouteInfo
    {
        $dispatcher = $this->getDispatcher();
        $httpMethod = $request->getMethod();
        $uri = $request->getPath();
        $result = $dispatcher->dispatch($httpMethod, $uri);

        $routeInfo = new RouteInfo();
        $routeInfo->matchResult = $result[0];

        switch ($result[0]) {

            case Dispatcher::NOT_FOUND:
                throw new NotFoundHttpException('Route not found');
                break;

            case Dispatcher::METHOD_NOT_ALLOWED:
                throw new MethodNotAllowedHttpException('Method not allowed');
                break;

            case Dispatcher::FOUND:
                $routeInfo->handler = $result[1]['handler'];
                $routeInfo->middleware = $result[1]['middleware'];
                $routeInfo->uriParameters = $result[2];
                break;
        }

        return $routeInfo;
    }

    private function getDispatcher(): Dispatcher
    {
        $config = appServiceProvider(Configuration::class);

        if ($config->get('env.production')) {
            return cachedDispatcher($this->routeCollection, [
                'cacheFile' => $config->get('path.cache') . '/routes.php',
            ]);
        }

        return simpleDispatcher($this->routeCollection);
    }
}