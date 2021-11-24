<?php

namespace App\Core\Exceptions\Http;

use App\Core\Http\HttpStatusCode;

class ConflictHttpException extends HttpException
{
    public function __construct(string $message)
    {
        parent::__construct($message, HttpStatusCode::Conflict);
    }
}