<?php

namespace App\Features\Users\Services;

use App\Core\Exceptions\Http\NotFoundHttpException;
use App\Features\Users\Dtos\CreatedStudentInviteDto;
use App\Features\Users\Repositories\UsersRepository;
use App\Features\Users\Dtos\GetUserProfileDto;
use App\Features\Users\Dtos\CreateStudentInviteDto;
use App\Features\Users\Repositories\InvitesRepository;
use App\Shared\Utils\Random;
use App\Shared\Utils\RandomTextType;
use App\Shared\Utils\Time;

class UsersService
{
    private UsersRepository $usersRepo;

    public function __construct()
    {
        $this->usersRepo = new UsersRepository();
    }

    public function getProfile(string|int $userId): GetUserProfileDto
    {
        $item = $this->usersRepo->getUserProfile($userId);

        if ($item === null) {
            throw new NotFoundHttpException(
                "User with ID {$userId} does not exist"
            );
        }

        $dto = new GetUserProfileDto();
        $dto->userId = $item['user_id'];
        $dto->createdOn = Time::getTimestamp($item['created_on']);
        $dto->firstName = $item['first_name'];
        $dto->lastName = $item['last_name'];
        $dto->role = $item['role'];
        $dto->email = $item['email'];
        
        return $dto;
    }

    public function generateStudentInvite(
        CreateStudentInviteDto $dtoIn,
    ): CreatedStudentInviteDto
    {
        $dtoIn->token = Random::getRandomText(RandomTextType::AlphaNumeric, 32);
        $invitesRepo = new InvitesRepository();
        $inviteId = $invitesRepo->createStudentInvite($dtoIn);

        $dtoOut = new CreatedStudentInviteDto();
        $dtoOut->inviteId = $inviteId;
        $dtoOut->token = $dtoIn->token;
        $dtoOut->email = $dtoIn->email;
        $dtoOut->userRoleId = $dtoIn->userRoleId;
        $dtoOut->courseId = $dtoIn->courseId;

        return $dtoOut;
    }
}
