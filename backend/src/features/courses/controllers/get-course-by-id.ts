import { createRoute, Request, Response } from '@/core/routing';

export const getCourseById = createRoute.get('/:courseid',
  // Add middlewares here...
  (req: Request, res: Response) => {
    res.send('Get course by ID: ' + req.params.courseid);
  },
);
