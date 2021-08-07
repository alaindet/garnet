<?php

namespace App\Core;

use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;

abstract class Middleware
{
    const RUN_BEFORE = -1;
    const RUN_AFTER = 1;

    /**
     * Does it run before or after the main request handler (the controller)?
     */
    const TIMING = self::RUN_BEFORE;

    public function process(Request $req, Response $res, ...$args): Response
    {
        // Override in child classes...

        return $res;
    }
}
