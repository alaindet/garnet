export class GetUserProfileDto {
  userId!: string | number;
  createdOn!: string | number | Date;
  firstName!: string;
  lastName!: string;
  role!: string;
  email!: string;
}
