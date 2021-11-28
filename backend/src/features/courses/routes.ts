import express from 'express';

import { coursesController } from './controllers/courses.controller';

const prefix = 'courses';
const routes = express.Router();

routes.get('/', coursesController.getAll);

export const coursesRouter = {
  routes,
  prefix,
};
