import { createRoute, Request, Response } from '@/core/routing';

export const getTasksByBoardAsStudent = createRoute.get('/as-student/:studentid',
  // Add middlewares here...
  (req: Request, res: Response) => {
    const message = 'Get tasks by board as student';
    const data = null;
    res.json({ message, data });
  },
);
