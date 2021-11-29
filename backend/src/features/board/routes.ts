import { createRoutes } from '@/core/routing';
import * as controllers from './controllers';

export const boardRoutes = createRoutes('/board', controllers);
