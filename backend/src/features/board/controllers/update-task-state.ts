import { createRoute, Request, Response } from '@/core/routing';

export const updateTaskState = createRoute.put('/tasks/:taskid',
  // Add middlewares here...
  (req: Request, res: Response) => {
    const message = 'Update task state';
    const data = null;
    res.json({ message, data });
  },
);
