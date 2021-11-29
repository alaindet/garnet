import { createRoute, Request, Response } from '@/core/routing';

export const updateCourse = createRoute.patch('/:courseid',
  // Add middlewares here...
  (req: Request, res: Response) => {
    const message = 'Update course';
    const data = null;
    res.json({ message, data });
  },
);
