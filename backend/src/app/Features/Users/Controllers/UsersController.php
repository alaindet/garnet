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

    public function generateStudentInvite(Request $req, Response $res): Response
    {
        $dto = $req->getValidatedData('dto');

        $invite = $this->usersService->generateStudentInvite($dto);

        $res->setBody([
            'message' => (
                "Student {$dto->email} was invited to ".
                "join course #{$dto->courseId}"
            ),
            'data' => $invite,
        ]);

        return $res;
    }

    public function checkInviteValidity(Request $req, Response $res): Response
    {
        $inviteDto = $req->getValidatedData('dto');

        $res->setBody([
            'message' => 'Invite token is valid',
            'data' => (bool) $this->usersService->checkInviteToken($inviteDto),
        ]);

        return $res;
    }

    public function acceptInviteBySigningIn(Request $req, Response $res): Response
    {
        $acceptDto = $req->getValidatedData('dto');
        $acceptedDto = $this->usersService->acceptInviteBySigningIn($acceptDto);

        $res->setBody([
            'message' => 'Invite accepted by signing in',
            'data' => $acceptedDto,
        ]);

        return $res;
    }

    public function acceptInviteBySigningUp(Request $req, Response $res): Response
    {
        $acceptDto = $req->getValidatedData('dto');
        $acceptedDto = $this->usersService->acceptInviteBySigningUp($acceptDto);

        $res->setBody([
            'message' => 'Invite accepted by signing up',
            'data' => $acceptedDto,
        ]);

        return $res;
    }
}
