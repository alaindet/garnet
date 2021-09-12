<?php

namespace App\Features\Users\Services;

use App\Core\Exceptions\Http\NotFoundHttpException;
use App\Features\Users\Repositories\UsersRepository;
use App\Features\Users\Dtos\GetUserProfileDto;
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
}
