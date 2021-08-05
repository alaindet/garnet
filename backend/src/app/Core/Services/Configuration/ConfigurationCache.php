<?php

namespace App\Core\Services\Configuration;

use App\Core\Services\Filesystem\Format\PhpAssociativeArray;

trait ConfigurationCache
{
    private string $cachePath;

    protected function setCachePath(string $cachePath): void
    {
        $this->cachePath = $cachePath;
    }

    protected function cacheExists(): bool
    {
        return file_exists($this->cachePath);
    }

    protected function fetchFromCache()
    {
        // Works only on .php files
        return require $this->cachePath;
    }

    protected function storeIntoCache(): void
    {
        $data = PhpAssociativeArray::toFileContent($this->data);
        file_put_contents($this->cachePath, $data);
    }
}
