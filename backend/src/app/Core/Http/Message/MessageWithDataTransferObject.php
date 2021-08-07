<?php

namespace App\Core\Http\Message;

trait MessageWithDataTransferObject
{
    protected $dto = null;

    public function setDto($dto): void
    {
        $this->dto = $dto;
    }

    public function getDto()
    {
        return $this->dto;
    }
}