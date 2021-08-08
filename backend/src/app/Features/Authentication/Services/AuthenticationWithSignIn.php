<?php

namespace App\Features\Authentication\Services;

use Firebase\JWT\JWT;

use App\Core\Exceptions\Http\UnauthorizedHttpException;
use App\Features\Authentication\Dtos\{LoginUserDto, LoggedUserDto};

trait AuthenticationWithSignIn
{
    public function signIn(LoginUserDto $dtoIn): LoggedUserDto
    {
        $user = $this->validateLoginDto($dtoIn);

        // TODO: Add session to database...

        [$jwt, $claims] = $this->buildJwt($user);

        $dtoOut = new LoggedUserDto();
        $dtoOut->email = $dtoIn->email;
        $dtoOut->role = 'TODO: Add role';
        $dtoOut->jwt = $jwt;
        $dtoOut->expireAt = $claims['exp'];

        return $dtoOut;
    }

    private function validateLoginDto(LoginUserDto $dto): array
    {
        $user = $this->usersRepo->findUserByEmail(
            $dto->email,
            ['email', 'password', 'user_id']
        );

        $userMissing = $user === null;
        $wrongPassword = !password_verify($dto->password, $user['password']);

        if ($userMissing || $wrongPassword) {
            $message = 'Wrong email or password';
            throw new UnauthorizedHttpException($message);
        }

        return $user;
    }

    private function buildJwt(array $user): array
    {
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

        $jwtSecret = $config->get('security.jwt.secret');
        $jwt = JWT::encode($claims, $jwtSecret);

        return [$jwt, $claims];
    }
}