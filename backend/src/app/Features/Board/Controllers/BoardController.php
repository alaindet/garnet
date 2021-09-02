<?php

namespace App\Features\Board\Controllers;

use App\Core\Controller;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;
use App\Features\Board\Services\BoardService;
use App\Features\Board\Dtos\GetBoardTasksRequest;

class BoardController extends Controller
{
    private BoardService $boardService;

    public function __construct()
    {
        $this->boardService = new BoardService();
    }

    public function getTasksByBoard(Request $req, Response $res): Response
    {
        $res->setBody([
            'message' => 'getTasksByBoard',
            'data' => null,
        ]);

        return $res;
    }

    public function updateTaskState(Request $req, Response $res): Response
    {
        $res->setBody([
            'message' => 'getTasksByBoard',
            'data' => null,
        ]);

        return $res;
    }
}
