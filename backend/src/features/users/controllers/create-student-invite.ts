import { createRoute, Request, Response } from '@/core/routing';

export const createStudentInvite = createRoute.post('/invite/student',
  // Add middlewares here...
  (req: Request, res: Response) => {
    const message = 'Create invite for student';
    const data = null;
    res.json({ message, data });
  },
);
