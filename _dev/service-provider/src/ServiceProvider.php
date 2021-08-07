<?php

namespace App;

class ServiceProvider
{
    use Singleton;

    private $providers = [];
    private $instances = [];

    public function has(string $className): bool
    {
        return isset($this->instances[$className]);
    }

    public function get(string $className)
    {
        if (!isset($this->instances[$className])) {
            $provider = $this->providers[$className];
            $this->instances[$className] = $provider($this);
        }

        return $this->instances[$className];
    }

    public function set(string $className, callable $provider): void
    {
        $this->providers[$className] = $provider;
    }
}