import { RequestHandler } from 'express';

import { HttpMethod } from './http-method';

export interface Route {
  httpMethod: HttpMethod;
  path: string;
  handlers: RequestHandler[];
};
