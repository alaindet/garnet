import { createRoute, Request, Response } from '@/core/routing';

export const updateTask = createRoute.patch('/:taskid',
  // Add middlewares here...
  (req: Request, res: Response) => {
    const message = 'Update task';
    const data = null;
    res.json({ message, data });
  },
);
