<?php

namespace App\Features\Users\Controllers;

use App\Core\Controller;
use App\Core\Exceptions\Http\UnauthorizedHttpException;
use App\Core\Http\Request\Request;
use App\Core\Http\Response\Response;
use App\Features\Authentication\Dtos\SignInUserDto;
use App\Features\Authentication\Services\AuthenticationService;
use App\Features\Users\Dtos\CheckInviteDto;
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
        $dto = $req->getValidatedData('dto');

        $isTokenValid = $this->usersService->checkInviteToken($dto);

        $res->setBody([
            'message' => 'Invite token is ' . ($isTokenValid ? '' : 'in'). 'valid',
            'data' => $isTokenValid,
        ]);

        return $res;
    }

    public function acceptInviteBySignIn(Request $req, Response $res): Response
    {
        $dto = $req->getValidatedData('dto');

        // Check token
        $checkInviteDto = new CheckInviteDto;
        $checkInviteDto->token = $dto->token;
        $isTokenValid = $this->usersService->checkInviteToken($checkInviteDto);

        if (!$isTokenValid) {
            throw new UnauthorizedHttpException(
                'Invalid or expired token'
            );
        }

        // Try authenticating the user
        $authService = new AuthenticationService;
        $signInDto = new SignInUserDto();
        $signInDto->email = $dto->email;
        $signInDto->password = $dto->password;
        $signedInDto = $authService->signIn($signInDto);

        $this->usersService->acceptInviteBySignIn($dto->token);

        $res->setBody([
            'message' => 'Student :student accepted the invite to join course #:course',
            'data' => null,
        ]);

        return $res;
    }
}
