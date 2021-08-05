<?php

namespace App\Core\Routing\Router;

use FastRoute\Dispatcher;
use function FastRoute\simpleDispatcher;
use function FastRoute\cachedDispatcher;

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

            // TODO: Error request handler
            case Dispatcher::NOT_FOUND:
                echo '404 NOT FOUND';
                die();
                break;

            // TODO: Error request handler
            case Dispatcher::METHOD_NOT_ALLOWED:
                echo '405 METHOD NOT ALLOWED';
                die();
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
        $config = Configuration::getInstance();

        if ($config->get('env.development') === true) {
            return simpleDispatcher($this->routeCollection);
        }

        return cachedDispatcher($this->routeCollection, [
            'cacheFile' => $config->get('path.cache') . '/routes.php',
        ]);
    }
}