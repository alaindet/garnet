import { createRoute, Request, Response } from '@/core/routing';

export const deleteCourse = createRoute.delete('/:courseid',
  // Add middlewares here...
  (req: Request, res: Response) => {
    const message = 'Delete course';
    const data = null;
    res.json({ message, data });
  },
);
