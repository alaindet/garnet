import express, { Request, Response } from 'express';

const router = express.Router();

router.get(
  '/courses',
  // Some middleware...
  (req: Request, res: Response) => {
    res.send('Get all courses');
  },
);

export default router;
