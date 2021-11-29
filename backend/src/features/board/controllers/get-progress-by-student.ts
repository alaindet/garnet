import { createRoute, Request, Response } from '@/core/routing';

export const getProgressByStudent = createRoute.get('/progress/by-student',
  // Add middlewares here...
  (req: Request, res: Response) => {
    const message = 'Get progress by student';
    const data = null;
    res.json({ message, data });
  },
);
