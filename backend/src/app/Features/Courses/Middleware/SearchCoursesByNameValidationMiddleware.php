<?php

namespace App\Features\Courses\Middleware;

use App\Core\Exceptions\Http\BadRequestHttpException;
use App\Core\Middleware;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;

class SearchCoursesByNameValidationMiddleware extends Middleware
{
    const TIMING = self::RUN_BEFORE;

    public function process(Request $req, Response $res, ...$args): Response
    {
        $courseName = $req->getQueryParameter('name');

        if ($courseName === null) {
            throw new BadRequestHttpException(
                'Provide a "name" query parameter'
            );
        }

        $req->setValidatedData(['name' => $courseName]);

        return $res;
    }
}
