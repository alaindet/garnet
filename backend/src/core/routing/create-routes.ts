import express from 'express';

import { trimSlash } from '@/shared/utils';
import { Route } from './route';

export const createRoutes = (
  prefix: string,
  routes: { [route: string]: Route },
): express.Router => {
  const router = express.Router();
  for (const route of Object.values(routes)) {
    const { httpMethod, path, handlers } = route;
    const sanitizedPath = trimSlash(path);
    router[httpMethod](`${prefix}/${sanitizedPath}`, ...handlers);
  }
  return router;
};
