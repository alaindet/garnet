<?php

namespace App\Core\Routing\Route;

use App\Core\Middleware;
use App\Core\Common\GetterSetter;

class Route
{
    use GetterSetter;
    use RouteHttpMethodsHelpers;

    private ?string $_method = null;
    private ?string $_path = null;
    private ?string $_handler = null;
    private $_middleware = [];
    private $_pathConstraints = [];

    public function __construct(
        ?string $method = null,
        ?string $path = null,
        ?string $handler = null
    ) {
        $this->_method = $method ?? null;
        $this->_handler = $handler ?? null;

        if (isset($path)) {
            $this->_path = ($path === '/') ? '' : $path;
        }
    }

    public function method(?string $method = null)
    {
        return $this->getOrSet('_method', $method);
    }

    public function path(?string $path = null)
    {
        if (!isset($path)) {
            return $this->_path;
        }

        $this->_path = $path;

        if (!empty($this->_pathConstraints)) {
            $this->_path = $this->mergePathWithConstraints();
        }
        
        return $this;
    }

    public function handler(?string $handler = null)
    {
        return $this->getOrSet('_handler', $handler);
    }

    /**
     * Adds one single middleware class name to existing ones
     */
    public function middleware(string $middlewareClass = null, ?array $args = null)
    {
        if ($middlewareClass === null) {
            return $this->_middleware;
        }

        $middlewareConfig = [$middlewareClass, $args ?? []];
        $this->_middleware[] = $middlewareConfig;

        return $this;
    }

    /**
     * Resets all middleware to given argument
     */
    public function setMiddleware(array|string $middlewareConfigs): self
    {
        $this->_middleware = \is_array($middlewareConfigs)
            ? $middlewareConfigs
            : [$middlewareConfigs];

        return $this;
    }

    public function pathConstraints(?array $pathConstraints = null)
    {
        if (!isset($pathConstraints)) {
            return $this->_pathConstraints;
        }

        $this->_pathConstraints = $pathConstraints;

        // Apply constraints path?
        if (!empty($this->_path)) {
            $this->_path = $this->mergePathWithConstraints();
        }

        return $this;
    }

    private function mergePathWithConstraints(): string
    {
        $replaceThese = [];
        $withTheseValues = [];

        foreach ($this->_pathConstraints as $key => $value) {
            $replaceThese[] = "{{$key}}";
            $withTheseValues[] = "{{$key}:{$value}}";
        }

        return str_replace($replaceThese, $withTheseValues, $this->_path);
    }
}
