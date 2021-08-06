<?php

namespace App\Features\Tests;

use App\Core\Routing\Route\Route;
use App\Core\Routing\RouteGroup;
use App\Features\Tests\Controllers\TestsController;

class Routes
{
    public static function register(): array
    {
        return (new RouteGroup)
            ->path('/tests')
            ->pathConstraints([ 'courseId' => '\d+' ])
            ->handler(TestsController::class)
            ->routes([
                Route::get('/courses', '@getAllCourses'),
                Route::get('/courses/{courseId}/students', '@getStudentsByCourse')
            ])
            ->collect();
    }
}
