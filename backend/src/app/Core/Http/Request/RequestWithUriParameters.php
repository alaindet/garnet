<?php

namespace App\Core\Http\Request;

trait RequestWithUriParameters
{
    protected array $uriParameters = [];

    public function getUriParameters(): array
    {
        return $this->uriParameters;
    }

    public function setUriParameters(array $uriParameters): self
    {
        $this->uriParameters = $uriParameters;

        return $this;
    }
}
