import { createRoute, Request, Response } from '@/core/routing';

export const getTaskById = createRoute.get('/:taskid',
  // Add middlewares here...
  (req: Request, res: Response) => {
    const message = 'Get task by ID';
    const data = null;
    res.json({ message, data });
  },
);
