import { UnixTimestamp } from '@app/shared/types';

export interface SignInResponse {
  email: string;
  role: string;
  expireAt: UnixTimestamp;
  jwt: string;
}