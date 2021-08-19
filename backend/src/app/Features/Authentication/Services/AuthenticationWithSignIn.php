<?php

namespace App\Features\Authentication\Services;

use Firebase\JWT\JWT;

use App\Shared\Utils\Time;
use App\Core\Exceptions\Http\UnauthorizedHttpException;
use App\Features\Authentication\Dtos\{LoginUserDto, LoggedUserDto};

trait AuthenticationWithSignIn
{
    public function signIn(LoginUserDto $dtoIn): LoggedUserDto
    {
        $user = $this->validateLoginDto($dtoIn);

        $dates = $this->computeTimeRange();
        $from = $dates['from']['timestamp'];
        $to = $dates['to']['timestamp'];

        $jwt = $this->buildJwt($user, $from, $to);

        $dtoOut = new LoggedUserDto();
        $dtoOut->jwt = $jwt;

        return $dtoOut;
    }

    private function validateLoginDto(LoginUserDto $dto): array
    {
        $fields = ['user_id', 'user_role_id', 'email', 'password'];

        $user = $this->usersRepo->findUserByEmail($dto->email, $fields);

        $userMissing = $user === null;
        $wrongPassword = !password_verify($dto->password, $user['password']);

        if ($userMissing || $wrongPassword) {
            $message = 'Wrong email and/or password';
            throw new UnauthorizedHttpException($message);
        }

        return $user;
    }

    private function computeTimeRange(): array
    {
        $fromTimestamp = Time::getTimestampInSeconds();
        $diff = appConfig('security.jwt.expires');
        $toTimestamp = $fromTimestamp + $diff;

        $fromDate = Time::getDateFromSeconds($fromTimestamp);
        $toDate = Time::getDateFromSeconds($toTimestamp);

        return [
            'from' => [
                'timestamp' => $fromTimestamp,
                'date' => $fromDate,
            ],
            'to' => [
                'timestamp' => $toTimestamp,
                'date' => $toDate,
            ],
        ];
    }

    private function buildJwt(
        array $user,
        string $fromDate,
        string $toDate
    ): string
    {
        $config = appConfig();

        $issuerClaim = $config->get('security.jwt.issuer');
        $subjectClaim = $user['user_id'];
        $issuedAtClaim = $fromDate;
        $expiresInClaim = $toDate;
        $notBeforeClaim = $fromDate;

        $claims = [

            // Standard
            'iss' => $issuerClaim,
            'sub' => $subjectClaim,
            'exp' => $expiresInClaim,
            'nbf' => $notBeforeClaim,
            'iat' => $issuedAtClaim,

            // Custom
            'app.role' => $user['user_role_id'],
        ];

        $jwtSecret = $config->get('security.jwt.secret');
        $jwt = JWT::encode($claims, $jwtSecret);

        return $jwt;
    }
}
