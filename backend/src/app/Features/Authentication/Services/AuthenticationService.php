<?php

namespace App\Features\Authentication\Services;

use Firebase\JWT\JWT;

use App\Core\Exceptions\Http\UnauthorizedHttpException;
use App\Features\Users\Repositories\UsersRepository;
use App\Features\Authentication\Dtos\{LoginUserDto, LoggedUserDto};

class AuthenticationService
{
    private UsersRepository $usersRepo;

    public function __construct()
    {
        $this->usersRepo = new UsersRepository;
    }

    public function login(LoginUserDto $dtoIn): LoggedUserDto
    {
        $user = $this->usersRepo->findUserByEmail(
            $dtoIn->email,
            ['email', 'password', 'user_id']
        );

        $userMissing = $user === null;
        $wrongPassword = !password_verify($dtoIn->password, $user['password']);

        if ($userMissing || $wrongPassword) {
            $message = 'Wrong email or password';
            throw new UnauthorizedHttpException($message);
        }

        // TODO: Add session to database...

        $config = appConfig();
        $issuerClaim = $config->get('security.jwt.issuer');
        $subjectClaim = $user['user_id']; // TODO: Session id?
        $issuedAtClaim = time();
        $expiresInClaim = $issuedAtClaim + $config->get('security.jwt.expires');
        $notBeforeClaim = $issuedAtClaim;

        $claims = [
            'iss' => $issuerClaim,
            'sub' => $subjectClaim,
            'exp' => $expiresInClaim,
            'nbf' => $notBeforeClaim,
            'iat' => $issuedAtClaim,
        ];

        $jwt = JWT::encode($claims, $config->get('security.jwt.secret'));

        $dtoOut = new LoggedUserDto();
        $dtoOut->email = $dtoIn->email;
        $dtoOut->jwt = $jwt;
        $dtoOut->expireAt = $expiresInClaim;

        return $dtoOut;
    }
}