import { createRoutes } from '@/core/routing';
import * as controllers from './controllers';

export const tasksRoutes = createRoutes('/tasks', controllers);
