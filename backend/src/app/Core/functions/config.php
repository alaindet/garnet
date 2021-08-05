<?php

use App\Core\Services\Configuration\Configuration;

function appConfig(string $name)
{
    return (Configuration::getInstance())->get($name);
}