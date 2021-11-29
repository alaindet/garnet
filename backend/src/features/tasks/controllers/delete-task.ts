import { createRoute, Request, Response } from '@/core/routing';

export const deleteTask = createRoute.delete('/:taskid',
  // Add middlewares here...
  (req: Request, res: Response) => {
    const message = 'Delete task';
    const data = null;
    res.json({ message, data });
  },
);
