<?php

namespace App\Core\Exceptions\Http;

class HttpException extends \Exception
{
    private int $statusCode;
    private $data = null;

    public function __construct(string $message, int $statusCode = null)
    {
        parent::__construct($message);

        if ($statusCode !== null) {
            $this->statusCode = $statusCode;
        }
    }

    public function setData($data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
