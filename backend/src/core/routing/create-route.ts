import { RequestHandler } from 'express';

import { HttpMethod } from './http-method';
import { Route } from './route';


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
