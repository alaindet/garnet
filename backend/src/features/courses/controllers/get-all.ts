import { createRoute, Request, Response } from '@/core/routing';

export const getAll = createRoute.get('/',
  // Some middleware...
  (req: Request, res: Response) => {
    res.send('Get all courses');
  },
);
