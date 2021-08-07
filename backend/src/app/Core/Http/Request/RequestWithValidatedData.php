<?php

namespace App\Core\Http\Request;

trait RequestWithValidatedData
{
    protected $data = null;

    public function setValidatedData($data): void
    {
        $this->data = $data;
    }

    public function getValidatedData()
    {
        return $this->data;
    }
}
