import { createRoute, Request, Response } from '@/core/routing';

export const getById = createRoute.get(
  '/:courseid',
  // Some middleware...
  (req: Request, res: Response) => {
    res.send('Get course by ID: ' + req.params.courseid);
  },
);
