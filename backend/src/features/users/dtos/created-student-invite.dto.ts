import { UserRole } from '@/features/users';

export class CreatedStudentInviteDto {
  inviteId!: string | number;
  token!: string;
  email!: string;
  expiresOn!: string | number | Date;
  userRoleId!: UserRole;
  courseId!: string | number;
}
