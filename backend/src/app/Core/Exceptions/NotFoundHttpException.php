<?php

namespace App\Core\Exceptions;

use App\Core\Http\HttpStatusCode;

class NotFoundHttpException extends HttpException
{
    public function __construct(string $message)
    {
        parent::__construct($message, HttpStatusCode::NotFound);
    }
}