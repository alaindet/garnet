import { createRoute, Request, Response } from '@/core/routing';

export const checkInviteValidity = createRoute.post('/invite/check',
  // Add middlewares here...
  (req: Request, res: Response) => {
    const message = 'Check invite validity';
    const data = null;
    res.json({ message, data });
  },
);
