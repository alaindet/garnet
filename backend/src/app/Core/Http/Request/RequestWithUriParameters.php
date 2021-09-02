<?php

namespace App\Core\Http\Request;

trait RequestWithUriParameters
{
    protected array $uriParameters = [];

    public function getUriParameters(array|null $keys = null): array
    {
        if (!isset($keys)) {
            return $this->uriParameters;
        }

        $data = [];

        foreach ($keys as $key) {
            $data[] = $this->uriParameters[$key];
        }

        return $data;
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
