import { Request, Response } from 'express';

import { createRoute, HttpMethod } from '../../../core/routing';

export const getById = createRoute(
  HttpMethod.Get,
  '/:courseid',
  // Some middleware...
  (req: Request, res: Response) => {
    res.send('Get course by ID');
  },
);
