<?php

namespace App\Features\Todos\Controllers;

use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;

class TodosController
{
    public function getAll(Request $req, Response $res, ...$args): Response
    {
        $res->setBody([
            'message' => 'All todos',
        ]);

        return $res;
    }

    // ...
}