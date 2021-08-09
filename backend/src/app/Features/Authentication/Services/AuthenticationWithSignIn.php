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
        [$fromDate, $toDate] = $this->computeTimeRange();
        $userSessionHash = $this->userSessionsRepo->create($user, $fromDate, $toDate);
        [$jwt, $claims] = $this->buildJwt($userSessionHash, $fromDate, $toDate);

        $dtoOut = new LoggedUserDto();
        $dtoOut->jwt = $jwt;
        $dtoOut->expireAt = $toDate;

        return $dtoOut;
    }

    private function validateLoginDto(LoginUserDto $dto): array
    {
        $user = $this->usersRepo->findUserByEmail(
            $dto->email,
            ['user_id', 'role_id', 'email', 'password']
        );

        $userMissing = $user === null;
        $wrongPassword = !password_verify($dto->password, $user['password']);

        if ($userMissing || $wrongPassword) {
            $message = 'Wrong email or password';
            throw new UnauthorizedHttpException($message);
        }

        return $user;
    }

    private function computeTimeRange(): array
    {
        $dateFormat = 'Y-m-d H:i:s';
        $fromTimestamp = time();
        $toTimestamp = $fromTimestamp + appConfig('security.jwt.expires');
        $fromDate = date($dateFormat, $fromTimestamp);
        $toDate = date($dateFormat, $toTimestamp);

        return [$fromDate, $toDate];
    }

    private function buildJwt(
        string $userSessionHash,
        string $fromDate,
        string $toDate
    ): array
    {
        $config = appConfig();

        $issuerClaim = $config->get('security.jwt.issuer');
        $subjectClaim = $userSessionHash;
        $issuedAtClaim = $fromDate;
        $expiresInClaim = $toDate;
        $notBeforeClaim = $fromDate;

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
