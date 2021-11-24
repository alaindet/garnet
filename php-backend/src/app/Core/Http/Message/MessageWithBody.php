<?php

namespace App\Core\Http\Message;

trait MessageWithBody
{
    protected $body = null;

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body): self
    {
        $this->body = $body;

        return $this;
    }
}
