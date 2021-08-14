<?php

namespace App\Features\Courses\Middleware;

use App\Core\Middleware;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;

class CreateCourseValidationMiddleware extends Middleware
{
    const TIMING = self::RUN_BEFORE;

    public function process(Request $req, Response $res, ...$args): Response
    {
        // TODO: Validation needed...

        return $res;
    }
}
