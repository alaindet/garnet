<?php

namespace App\Core\Exceptions;

use App\Core\Http\HttpStatusCode;

class UnauthorizedHttpException extends HttpException
{
    public function __construct(string $message)
    {
        parent::__construct($message, HttpStatusCode::Unauthorized);
    }
}