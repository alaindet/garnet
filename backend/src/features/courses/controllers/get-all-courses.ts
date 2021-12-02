import { createRoute, Request, Response } from '@/core/routing';
import { ValidationSchema, validate } from '@/core/validation';
// import { database } from '@/core/database';

export const getAllCourses = createRoute.get('/',
  // Add middlewares here...
  async (req: Request, res: Response) => {
    // const result = await database.raw('SELECT * FROM "public"."courses"');
    const message = 'Get all courses';
    // const data = null;

    const input = {
      foo: 123,
    };

    const schema: ValidationSchema = {
      foo: {
        isString: true,
      },
    };

    const data = validate(input, schema);

    // const data = result.rows;
    res.json({ message, data });
  },
);
