import { createRoute, Request, Response } from '@/core/routing';

export const getUserProfile = createRoute.get('/profile',
  // Add middlewares here...
  (req: Request, res: Response) => {
    const message = 'Get user profile';
    const data = null;
    res.json({ message, data });
  },
);
