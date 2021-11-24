<?php

namespace App\Core\Http\Response;

use App\Core\Http\Message\Message;

class Response extends Message
{
    protected int $statusCode = 200;

    public function __construct(?int $statusCode = null)
    {
        if ($statusCode !== null) {
            $this->statusCode = $statusCode;
        }
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }
}
