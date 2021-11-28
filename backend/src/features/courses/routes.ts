import { createRoutes } from '../../core/routing';
import * as controllers from './controllers';

export default createRoutes('/courses', controllers);
