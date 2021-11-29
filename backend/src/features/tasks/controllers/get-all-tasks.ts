import { createRoute, Request, Response } from '@/core/routing';

export const getAllTasks = createRoute.get('/',
  // Add middlewares here...
  (req: Request, res: Response) => {
    const message = 'Get all tasks';
    const data = null;
    res.json({ message, data });
  },
);
