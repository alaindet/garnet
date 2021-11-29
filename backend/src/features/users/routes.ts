import { createRoutes } from '@/core/routing';
import * as controllers from './controllers';

export const usersRoutes = createRoutes('/users', controllers);
