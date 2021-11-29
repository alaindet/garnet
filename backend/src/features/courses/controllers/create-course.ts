import { createRoute, Request, Response } from '@/core/routing';

export const createCourse = createRoute.post('/',
  // Add middlewares here...
  (req: Request, res: Response) => {
    const message = 'Create course';
    const data = null;
    res.json({ message, data });
  },
);
