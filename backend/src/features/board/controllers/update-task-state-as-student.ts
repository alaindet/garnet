import { createRoute, Request, Response } from '@/core/routing';

export const updateTaskStateAsStudent = createRoute.put(
  '/tasks/:taskid/as-student/:studentid',
  // Add middlewares here...
  (req: Request, res: Response) => {
    const message = 'Update task state as student';
    const data = null;
    res.json({ message, data });
  },
);
