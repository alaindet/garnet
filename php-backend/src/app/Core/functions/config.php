<?php

use App\Core\Services\ServiceProvider;
use App\Core\Services\Configuration\Configuration;

function appConfig(?string $name = null)
{
    $sp = ServiceProvider::getInstance();
    $config = $sp->get(Configuration::class);

    if (!isset($name)) {
        return $config;
    }

    return $config->get($name);
}