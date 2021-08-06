<?php

namespace App\Core\Exceptions;

class HttpException extends \Exception
{
    private int $statusCode;

    public function __construct(string $message, int $statusCode = null)
    {
        parent::__construct($message);

        if ($statusCode !== null) {
            $this->statusCode = $statusCode;
        }
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
