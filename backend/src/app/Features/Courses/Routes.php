<?php

namespace App\Features\Courses;

use App\Core\Routing\Route\Route;
use App\Core\Routing\RouteGroup;
use App\Features\Courses\Controllers\CoursesController;

class Routes
{
    public static function register(): array
    {
        return (new RouteGroup)
            ->path('/courses')
            ->pathConstraints([ 'id' => '\d+' ])
            ->handler(CoursesController::class)
            ->routes([
                Route::post('/', '@create'),
                // Route::get('/', '@getAllByTeacher'),
                // Route::get('/{id}', '@getById'),
                // Route::patch('/{id}', '@update'),
                // Route::delete('/{id}', '@delete'),
            ])
            ->collect();
    }
}
