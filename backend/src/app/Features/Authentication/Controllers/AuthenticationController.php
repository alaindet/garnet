<?php

namespace App\Features\Authentication\Controllers;

use App\Core\Controller;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;
use App\Features\Authentication\Services\AuthenticationService;

class AuthenticationController extends Controller
{
    private AuthenticationService $authService;

    public function __construct()
    {
        $this->authService = new AuthenticationService();
    }

    public function login(Request $req, Response $res): Response
    {
        $dtoIn = $req->getDto();

        $dtoOut = $this->authService->login($dtoIn);

        $res->setBody([
            'message' => "$dtoIn->email logged in successfully",
            'data' => $dtoOut,
        ]);

        return $res;
    }
}
