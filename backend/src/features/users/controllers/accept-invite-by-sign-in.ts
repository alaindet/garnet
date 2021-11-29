import { createRoute, Request, Response } from '@/core/routing';

export const acceptInviteBySignIn = createRoute.post('/invite/accept/signin',
  // Add middlewares here...
  (req: Request, res: Response) => {
    const message = 'Accept invite by signin in';
    const data = null;
    res.json({ message, data });
  },
);
