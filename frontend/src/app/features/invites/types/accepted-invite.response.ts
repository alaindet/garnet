import { SuccessResponse } from '@app/core/types';

export interface AcceptedInvite {
  jwt: string;
  courseId?: string | number;
}

export type AcceptedInviteResponse = SuccessResponse<AcceptedInvite>;
