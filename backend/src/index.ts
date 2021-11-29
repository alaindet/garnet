import express from 'express';

import config from '@/config';
import { coursesRoutes } from '@/features/courses';
import { usersRoutes } from '@/features/users';
import { tasksRoutes } from '@/features/tasks';
import { boardRoutes } from '@/features/board';
import { authRoutes } from '@/features/authentication';

const app = express();

app.use(coursesRoutes);
app.use(usersRoutes);
app.use(tasksRoutes);
app.use(boardRoutes);
app.use(authRoutes);

app.listen(config.app.port, () => {
  console.log(`${config.app.name} running on port ${config.app.port}`);
});
