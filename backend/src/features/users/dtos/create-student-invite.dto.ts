import { UserRole } from '@/features/users';

export class CreateStudentInviteDto {
  token!: string;
  email!: string;
  expiresOn!: string | number | Date;
  userRoleId!: UserRole;
  courseId!: string | number;
}
