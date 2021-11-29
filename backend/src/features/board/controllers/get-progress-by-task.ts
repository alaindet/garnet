import { createRoute, Request, Response } from '@/core/routing';

export const getProgressByTask = createRoute.get('/progress/by-task',
  // Add middlewares here...
  (req: Request, res: Response) => {
    const message = 'Get progress by task';
    const data = null;
    res.json({ message, data });
  },
);
