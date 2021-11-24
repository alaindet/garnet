<?php

namespace App\Features\Tests\Controllers;

use App\Core\Controller;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;
use App\Core\Services\Database\Database;

class TestsController extends Controller
{
    private Database $db;

    public function __construct()
    {
        $this->db = appServiceProvider(Database::class);
    }

    public function index(Request $req, Response $res, ...$args): Response
    {
        $res->setBody([
            'message' => 'TestsController::index',
        ]);

        return $res;
    }

    public function authNeeded(Request $req, Response $res, ...$args): Response
    {
        $res->setBody([
            'message' => 'You have sufficient permissions to view this page',
        ]);

        return $res;
    }
}
