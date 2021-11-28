import express, { RequestHandler } from 'express';

export enum HttpMethod {
  Get = 'get',
  Post = 'post',
  Put = 'put',
  Patch = 'patch',
}

export interface Route {
  httpMethod: HttpMethod;
  path: string;
  handlers: RequestHandler[];
};

export const createRoute = (
  httpMethod: HttpMethod,
  path: string,
  ...handlers: RequestHandler[]
) => {
  return {
    httpMethod,
    path,
    handlers,
  };
};

export const createRoutes = (
  prefix: string,
  routes: { [route: string]: Route },
): express.Router => {
  const router = express.Router();
  for (const route of Object.values(routes)) {
    const { httpMethod, path, handlers } = route;
    router[httpMethod](`${prefix}/${path}`, ...handlers);
  }
  return router;
};
