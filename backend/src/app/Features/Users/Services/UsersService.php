<?php

namespace App\Features\Users\Services;

use App\Core\Exceptions\Http\NotFoundHttpException;
use App\Core\Exceptions\Http\UnauthorizedHttpException;
use App\Features\Authentication\Dtos\RegisterUserDto;
use App\Features\Authentication\Dtos\SignInUserDto;
use App\Features\Authentication\Services\AuthenticationService;
use App\Features\Courses\Repositories\CoursesRepository;
use App\Features\Tasks\Repositories\TasksRepository;
use App\Features\Users\Constants\UserConstants;
use App\Features\Users\Dtos\AcceptedInviteDto;
use App\Features\Users\Dtos\AcceptInviteByRegistrationDto;
use App\Features\Users\Dtos\AcceptInviteBySigningInDto;
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

    public function checkInviteToken(CheckInviteDto $dto): array
    {
        $invitesRepo = new InvitesRepository();

        $token = $dto->token;
        $invite = $invitesRepo->getInviteByToken($token);

        if ($invite === null) {
            $message = 'Invalid or expired token';
            $data = false;
            throw (new UnauthorizedHttpException($message))->setData($data);
        }

        $expiresOn = Time::getTimestamp($invite['expires_on']);
        $now = Time::getTimestamp();

        if ($now >= $expiresOn) {
            $invitesRepo->deleteInviteByToken($token);
            $message = 'Invalid or expired token';
            $data = false;
            throw (new UnauthorizedHttpException($message))->setData($data);
        }

        return $invite;
    }

    public function acceptInviteBySignIn(
        AcceptInviteBySigningInDto $acceptDto
    ): AcceptedInviteDto
    {
        $invitesRepo = new InvitesRepository();
        $authService = new AuthenticationService();
        $courseId = null;

        // Check token
        $checkInviteDto = new CheckInviteDto();
        $checkInviteDto->token = $acceptDto->token;
        $invite = $this->checkInviteToken($checkInviteDto);

        // Check email of requesting user
        if ($invite['email'] !== $acceptDto->email) {
            throw new UnauthorizedHttpException(
                "This invite is not associated to email {$acceptDto->email}"
            );
        }

        // Try authenticating the user
        $signInDto = new SignInUserDto();
        $signInDto->email = $acceptDto->email;
        $signInDto->password = $acceptDto->password;
        $signedInDto = $authService->signIn($signInDto);

        switch ($invite['user_role_id']) {

            case UserRole::Student:
                $courseId = $this->acceptStudentInvite($invite);
                break;

            case UserRole::Teacher:
                $this->acceptTeacherInvite($invite);
                break;
        }

        $invitesRepo->deleteInviteByToken($invite['token']);
        $acceptedInviteDto = new AcceptedInviteDto;
        $acceptedInviteDto->jwt = $signedInDto->jwt;
        $acceptedInviteDto->courseId = $courseId;

        return $acceptedInviteDto;
    }

    public function acceptInviteByRegistration(
        AcceptInviteByRegistrationDto $acceptDto
    ): AcceptedInviteDto
    {
        $invitesRepo = new InvitesRepository();
        $authService = new AuthenticationService();
        $courseId = null;

        // Check token
        $checkInviteDto = new CheckInviteDto();
        $checkInviteDto->token = $acceptDto->token;
        $invite = $this->checkInviteToken($checkInviteDto);

        // Check email of requesting user
        if ($invite['email'] !== $acceptDto->email) {
            throw new UnauthorizedHttpException(
                "This invite is not associated to email {$acceptDto->email}"
            );
        }

        // Try registering the user
        $registerDto = new RegisterUserDto();
        $registerDto->email = $acceptDto->email;
        $registerDto->password = $acceptDto->password;
        $registerDto->firstName = $acceptDto->firstName;
        $registerDto->lastName = $acceptDto->lastName;
        $registerDto->roleId = $invite['user_role_id'];

        $signedInDto = $authService->register($registerDto);

        switch ($invite['user_role_id']) {

            case UserRole::Student:
                $courseId = $this->acceptStudentInvite($invite);
                break;

            case UserRole::Teacher:
                $this->acceptTeacherInvite($invite);
                break;
        }

        $invitesRepo->deleteInviteByToken($invite['token']);
        $acceptedInviteDto = new AcceptedInviteDto();
        $acceptedInviteDto->jwt = $signedInDto->jwt;
        $acceptedInviteDto->courseId = $courseId;

        return $acceptedInviteDto;
    }

    private function acceptStudentInvite(array $invite): string | int
    {
        $user = $this->usersRepo->findUserByEmail($invite['email']);

        if (!isset($user)) {
            throw new NotFoundHttpException(
                'User not found'
            );
        }

        $courseId = $invite['course_id'];
        $studentId = $user['user_id'];

        (new CoursesRepository)->addStudentToCourse($courseId, $studentId);
        (new TasksRepository)->cloneStudentTasksFromCourse($courseId, $studentId);

        return $courseId;
    }

    private function acceptTeacherInvite(array $invite): void
    {
        // TODO...
    }
}
