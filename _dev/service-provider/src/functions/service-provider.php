<?php

use App\ServiceProvider;

function app_serviceProvider(?string $className = null)
{
    $sp = ServiceProvider::getInstance();
    return isset($className) ? $sp->get($className) : $sp;
}