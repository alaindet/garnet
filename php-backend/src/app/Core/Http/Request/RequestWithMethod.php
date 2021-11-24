<?php

namespace App\Core\Http\Request;

trait RequestWithMethod
{
    protected string $method = 'GET';

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }
}
