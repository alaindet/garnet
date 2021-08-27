import { Response } from '@app/shared/types';

export type SignInResponse = Response<{ jwt: string }>;
