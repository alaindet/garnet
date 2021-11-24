<?php

use App\Core\Services\ServiceProvider;

function appServiceProvider(?string $className)
{
    $sp = ServiceProvider::getInstance();
    
    if (isset($className)) {
        return $sp->get($className);
    }

    return $sp;
}