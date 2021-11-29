import { createRoutes } from '@/core/routing';
import * as controllers from './controllers';

export const coursesRoutes = createRoutes('/courses', controllers);
