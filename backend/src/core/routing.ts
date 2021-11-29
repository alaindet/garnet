import express, { Request as ExpressRequest, Response as ExpressResponse, RequestHandler } from 'express';

export enum HttpMethod {
  Get = 'get',
  Post = 'post',
  Put = 'put',
  Patch = 'patch',
  Delete = 'delete',
}

export interface Request extends ExpressRequest {};

export interface Response extends ExpressResponse {};

export interface Route {
  httpMethod: HttpMethod;
  path: string;
  handlers: RequestHandler[];
};

const _createRoute = (
  httpMethod: HttpMethod,
  path: string,
  ...handlers: RequestHandler[]
): Route => ({
  httpMethod,
  path,
  handlers,
});

export const createRoute = {
  [HttpMethod.Get]: (
    path: string,
    ...handlers: RequestHandler[]
  ) => _createRoute(HttpMethod.Get, path, ...handlers),

  [HttpMethod.Post]: (
    path: string,
    ...handlers: RequestHandler[]
  ) => _createRoute(HttpMethod.Post, path, ...handlers),

  [HttpMethod.Put]: (
    path: string,
    ...handlers: RequestHandler[]
  ) => _createRoute(HttpMethod.Put, path, ...handlers),

  [HttpMethod.Patch]: (
    path: string,
    ...handlers: RequestHandler[]
  ) => _createRoute(HttpMethod.Patch, path, ...handlers),

  [HttpMethod.Delete]: (
    path: string,
    ...handlers: RequestHandler[]
  ) => _createRoute(HttpMethod.Delete, path, ...handlers),
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
