<?php

namespace App\Core\Exceptions\Http;

use App\Core\Http\HttpStatusCode;

class InternalServerErrorHttpException extends HttpException
{
    public function __construct(string $message)
    {
        parent::__construct($message, HttpStatusCode::InternalServerError);
    }
}
