import { createRoute, Request, Response } from '@/core/routing';

export const createTask = createRoute.post('/',
  // Add middlewares here...
  (req: Request, res: Response) => {
    const message = 'Create task';
    const data = null;
    res.json({ message, data });
  },
);
