import { createRoute, Request, Response } from '@/core/routing';
import { database } from '@/core/database';

export const getAllCourses = createRoute.get('/',
  // Add middlewares here...
  async (req: Request, res: Response) => {
    const result = await database.raw('SELECT * FROM "public"."courses"');
    const message = 'Get all courses';
    const data = result.rows;
    res.json({ message, data });
  },
);
