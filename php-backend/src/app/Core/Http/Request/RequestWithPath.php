<?php

namespace App\Core\Http\Request;

trait RequestWithPath
{
    protected string $path = '';

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }
}
