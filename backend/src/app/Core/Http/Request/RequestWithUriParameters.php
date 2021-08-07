<?php

namespace App\Core\Http\Request;

trait RequestWithUriParameters
{
    protected array $uriParameters = [];

    public function getUriParameters(): array
    {
        return $this->uriParameters;
    }

    public function getUriParameter(string $name)
    {
        return $this->uriParameters[$name];
    }

    public function setUriParameters(array $uriParameters): self
    {
        $this->uriParameters = $uriParameters;

        return $this;
    }
}
