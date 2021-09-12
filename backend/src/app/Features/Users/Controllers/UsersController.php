<?php

namespace App\Features\Users\Controllers;

use App\Core\Controller;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;
use App\Features\Users\Services\UsersService;

class UsersController extends Controller
{
    private UsersService $usersService;

    public function __construct()
    {
        $this->usersService = new UsersService();
    }

    public function getProfile(Request $req, Response $res): Response
    {
        $userId = $req->getAuthenticationData('user_id');

        $res->setBody([
            'message' => "Profile data of user {$userId}",
            'data' => $this->usersService->getProfile($userId),
        ]);

        return $res;
    }
}
