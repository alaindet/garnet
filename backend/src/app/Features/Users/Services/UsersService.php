<?php

namespace App\Features\Users\Services;

use App\Core\Exceptions\Http\NotFoundHttpException;
use App\Features\Authentication\Dtos\SignedInUserDto;
use App\Features\Courses\Repositories\CoursesRepository;
use App\Features\Tasks\Repositories\TasksRepository;
use App\Features\Users\Constants\UserConstants;
use App\Features\Users\Dtos\CheckInviteDto;
use App\Features\Users\Dtos\CreatedStudentInviteDto;
use App\Features\Users\Dtos\CreateStudentInviteDto;
use App\Features\Users\Dtos\GetUserProfileDto;
use App\Features\Users\Dtos\AcceptedInviteBySignInDto;
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

    public function checkInviteToken(CheckInviteDto $dto): array | false
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

        return $invite;
    }

    public function acceptInviteBySignIn(
        array $invite,
        SignedInUserDto $signedInDto
    ): AcceptedInviteBySignInDto
    {
        $invitesRepo = new InvitesRepository();
        $courseId = null;

        switch ($invite['user_role_id']) {

            case UserRole::Student:
                $courseId = $this->acceptStudentInviteBySignIn($invite);
                break;

            case UserRole::Teacher:
                $this->acceptTeacherInviteBySignIn($invite);
                break;
        }

        $invitesRepo->deleteInviteByToken($invite['token']);
        $acceptedInviteDto = new AcceptedInviteBySignInDto;
        $acceptedInviteDto->jwt = $signedInDto->jwt;
        $acceptedInviteDto->courseId = $courseId;

        return $acceptedInviteDto;
    }

    private function acceptStudentInviteBySignIn(array $invite): string | int
    {
        $email = $invite['email'];
        $user = $this->usersRepo->findUserByEmail($email);

        if (!isset($user)) {
            throw new NotFoundHttpException(
                'User not found'
            );
        }

        $studentId = $user['user_id'];
        $courseId = $invite['course_id'];

        (new CoursesRepository)->addStudentToCourse($courseId, $studentId);
        (new TasksRepository)->cloneStudentTasksFromCourse($courseId, $studentId);

        return $courseId;
    }

    private function acceptTeacherInviteBySignIn(array $invite): void
    {
        // TODO...
    }
}
