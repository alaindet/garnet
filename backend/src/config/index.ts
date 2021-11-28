import { app } from './app';
import { cors } from './cors';
import { database } from './database';
import { environment } from './environment';
import { jwt } from './jwt';
import { path } from './path';

const config = {
  app,
  cors,
  database,
  environment,
  jwt,
  path,
};

export default config;
