<?php

namespace App\Features\Todos;

use App\Core\Routing\Route\Route;
use App\Core\Routing\RouteGroup;
use App\Features\Todos\Controllers\TodosController;

class Routes
{
    static public function register(): array
    {
        return (new RouteGroup)
            ->path('/todos')
            ->pathConstraints(['id' => '\d+'])
            ->handler(TodosController::class)
            ->routes([
                Route::post('/', '@create'),
                Route::get('/', '@getAll'),
                Route::get('/{id}', '@getOne'),
                Route::put('/{id}', '@update'),
                Route::delete('/{id}', '@delete'),
            ])
            ->collect();
    }
}