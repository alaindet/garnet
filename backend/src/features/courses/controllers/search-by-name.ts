import { createRoute, Request, Response } from '@/core/routing';

export const searchCourseByName = createRoute.get('/search/by-name',
  // Add middlewares here...
  (req: Request, res: Response) => {
    const message = 'Search courses by name';
    const data = null;
    res.json({ message, data });
  },
);
