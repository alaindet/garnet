import { SuccessResponse } from '@app/core/types';
import { DateTimeString } from '@app/shared/types';

export interface UserProfile {
  userId: string | number;
  createdOn: DateTimeString;
  firstName: string;
  lastName: string;
  role: string;
  email: string;
}

export type GetUserProfileResponse = SuccessResponse<UserProfile>;
