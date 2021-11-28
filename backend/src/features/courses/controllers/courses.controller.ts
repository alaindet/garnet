import { Request, Response, RequestHandler, Router } from 'express';

const getAll: RequestHandler = (req: Request, res: Response) => {
  // ...
};

const getById: RequestHandler = (req: Request, res: Response) => {
  // ...
};

export const coursesController = {
  getAll,
  getById,
}
