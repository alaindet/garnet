import { createRoute, Request, Response } from '@/core/routing';

export const getTasksByBoard = createRoute.get('/',
  // Add middlewares here...
  (req: Request, res: Response) => {
    const message = 'Get tasks by board';
    const data = null;
    res.json({ message, data });
  },
);
