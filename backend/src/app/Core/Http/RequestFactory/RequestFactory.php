<?php

namespace App\Core\Http\RequestFactory;

use App\Core\Http\RequestFactory\ServerRequest\WithServerRequest;

abstract class RequestFactory
{
    use WithServerRequest;
}
