import { createRoute, Request, Response } from '@/core/routing';

export const acceptInviteBySignUp = createRoute.post('/invite/accept/signup',
  // Add middlewares here...
  (req: Request, res: Response) => {
    const message = 'Accept invite by signin up';
    const data = null;
    res.json({ message, data });
  },
);
