import express from 'express';

import config from '@/config';
import { coursesRoutes } from '@/features/courses';
import { usersRoutes } from '@/features/users';
import { tasksRoutes } from '@/features/tasks';
import { boardRoutes } from '@/features/board';
import { authRoutes } from '@/features/authentication';

const app = express();
const version = 'v1.0';

app.use(version, coursesRoutes);
app.use(version, usersRoutes);
app.use(version, tasksRoutes);
app.use(version, boardRoutes);
app.use(version, authRoutes);

app.listen(config.app.port, () => {
  console.log(`${config.app.name} running on port ${config.app.port}`);
});
