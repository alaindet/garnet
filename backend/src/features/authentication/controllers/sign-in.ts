import { createRoute, Request, Response } from '@/core/routing';

export const signIn = createRoute.post('/signin',
  // Add middlewares here...
  (req: Request, res: Response) => {
    const message = 'Signed In';
    const data = null;
    res.json({ message, data });
  },
);
