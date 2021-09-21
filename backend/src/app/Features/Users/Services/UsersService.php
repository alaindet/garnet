<?php

namespace App\Features\Users\Services;

use App\Core\Exceptions\Http\NotFoundHttpException;
use App\Features\Courses\Repositories\CoursesRepository;
use App\Features\Tasks\Repositories\TasksRepository;
use App\Features\Users\Constants\UserConstants;
use App\Features\Users\Dtos\CheckInviteDto;
use App\Features\Users\Dtos\CreatedStudentInviteDto;
use App\Features\Users\Dtos\CreateStudentInviteDto;
use App\Features\Users\Dtos\GetUserProfileDto;
use App\Features\Users\Enums\UserRole;
use App\Features\Users\Repositories\InvitesRepository;
use App\Features\Users\Repositories\UsersRepository;
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
        $type = RandomTextType::AlphaNumeric;
        $length = UserConstants::INVITE_TOKEN_LENGTH;
        $dtoIn->token = Random::getRandomText($type, $length);
        $expireTimestamp = Time::getTimestampInSeconds() + 60*60*24;
        $dtoIn->expiresOn = Time::getDateFromSeconds($expireTimestamp);
        $invitesRepo = new InvitesRepository();
        $inviteId = $invitesRepo->createStudentInvite($dtoIn);

        $dtoOut = new CreatedStudentInviteDto();
        $dtoOut->inviteId = $inviteId;
        $dtoOut->token = $dtoIn->token;
        $dtoOut->email = $dtoIn->email;
        $dtoOut->expiresOn = $dtoIn->expiresOn;
        $dtoOut->userRoleId = $dtoIn->userRoleId;
        $dtoOut->courseId = $dtoIn->courseId;

        // TODO: Send email...

        return $dtoOut;
    }

    public function checkInviteToken(CheckInviteDto $dto): bool
    {
        $token = $dto->token;

        $invitesRepo = new InvitesRepository();
        $invite = $invitesRepo->getInviteByToken($token);

        if ($invite === null) {
            return false;
        }

        $expiresOn = Time::getTimestamp($invite['expires_on']);
        $now = Time::getTimestamp();

        if ($now >= $expiresOn) {
            $invitesRepo->deleteInviteByToken($token);
            return false;
        }

        return true;
    }

    public function acceptInviteBySignIn(string $token): void
    {
        $invitesRepo = new InvitesRepository();
        $invite = $invitesRepo->getInviteByToken($token);

        if (!isset($invite)) {
            throw new NotFoundHttpException(
                'Invite not found'
            );
        }

        switch ($invite['user_role_id']) {

            case UserRole::Student:
                $this->acceptStudentInviteBySignIn($invite);
                break;

            case UserRole::Teacher:
                $this->acceptTeacherInviteBySignIn($invite);
                break;
        }

        $invitesRepo->deleteInviteByToken($token);
    }

    private function acceptStudentInviteBySignIn(array $invite): void
    {
        $email = $invite['email'];
        $user = $this->usersRepo->findUserByEmail($email);

        if (!isset($user)) {
            throw new NotFoundHttpException(
                'User not found'
            );
        }

        $coursesRepo = new CoursesRepository();
        $courseId = $invite['course_id'];
        $studentId = $user['user_id'];
        $coursesRepo->addStudentToCourse($courseId, $studentId);

        $tasksRepo = new TasksRepository();
        // Clone all tasks into task_user

    }

    private function acceptTeacherInviteBySignIn(array $invite): void
    {
        // TODO...
    }
}
