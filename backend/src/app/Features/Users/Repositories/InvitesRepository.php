<?php

namespace App\Features\Users\Repositories;

use App\Core\Repository;
use App\Core\Services\Database\Database;
use App\Features\Users\Dtos\CreateStudentInviteDto;

class InvitesRepository extends Repository
{
    protected $table = 'invites';
    protected Database $db;

    public function __construct()
    {
        $this->db = appServiceProvider(Database::class);
    }

    public function createStudentInvite(CreateStudentInviteDto $dto): int
    {
        $sql = "
            INSERT INTO {$this->table}
                (token, email, user_role_id, course_id)
            VALUES
                (:token, :email, :roleid, :courseid)
            ON DUPLICATE KEY UPDATE
                token = :tokenagain
        ";

        $params = [
            ':token' => $dto->token,
            ':tokenagain' => $dto->token,
            ':email' => $dto->email,
            ':roleid' => $dto->userRoleId,
            ':courseid' => $dto->courseId,
        ];

        return $this->db->insert($sql, $params);
    }
}
