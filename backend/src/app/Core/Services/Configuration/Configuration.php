<?php

namespace App\Core\Services\Configuration;

use Dotenv\Dotenv;

use App\Core\Common\Singleton;
use App\Core\Services\Filesystem\Filesystem;

class Configuration
{
    use ConfigurationCache;

    /** @var array */
    private $data;

    private ConfigurationCache $cache;

    public function __construct(array $configMetadata)
    {
        $this->setCachePath($configMetadata['cachePath']);
        $this->initializeData($configMetadata);
    }

    public function get(string $key)
    {
        return $this->data[$key];
    }

    public function getData()
    {
        return $this->data;
    }

    private function buildData(string $configDir): array
    {
        $data = [];
        $files = Filesystem::scan($configDir);

        foreach ($files as $file) {
            $prefix = Filesystem::getFilename($file);
            $fileData = require_once $file;
            foreach ($fileData as $subkey => $value) {
                $key = "{$prefix}.{$subkey}";
                $data[$key] = $value;
            }
        }

        return $data;
    }

    private function initializeData($configMetadata): void
    {
        if ($this->cacheExists()) {
            $this->data = $this->fetchFromCache();
            return;
        }

        (Dotenv::createImmutable($configMetadata['envDir']))->load();

        $this->data = $this->buildData($configMetadata['configDir']);

        if ($_ENV['GARNET_APP_DEBUG'] === 'false') {
            $this->storeIntoCache();
        }
    }
}
