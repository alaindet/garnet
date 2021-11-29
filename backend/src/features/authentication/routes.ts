import { createRoutes } from '@/core/routing';
import * as controllers from './controllers';

export const authRoutes = createRoutes('/auth', controllers);
