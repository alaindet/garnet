import express from 'express';

import { coursesController } from './controllers';

const prefix = 'courses';
const routes = express.Router();

routes.get('/', coursesController.getAll);
routes.get('/:courseid', coursesController.getById);

export const coursesRouter = {
  routes,
  prefix,
};
