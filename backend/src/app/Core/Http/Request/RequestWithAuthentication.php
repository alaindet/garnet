<?php

namespace App\Core\Http\Request;

trait RequestWithAuthentication
{
    protected $auth;

    public function getAuthenticationData()
    {
        return $this->auth;
    }

    public function setAuthenticationData($auth): self
    {
        $this->auth = $auth;

        return $this;
    }
}
