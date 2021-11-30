import express from 'express';

import dotenv from 'dotenv';

dotenv.config({
  path: './.env.local',
});

import config from '@/config';
import { coursesRoutes } from '@/features/courses';
import { usersRoutes } from '@/features/users';
import { tasksRoutes } from '@/features/tasks';
import { boardRoutes } from '@/features/board';
import { authRoutes } from '@/features/authentication';

const app = express();
const version = `/v${process.env.GARNET_APP_VERSION_SHORT}`;

app.use(version, coursesRoutes);
app.use(version, usersRoutes);
app.use(version, tasksRoutes);
app.use(version, boardRoutes);
app.use(version, authRoutes);

app.listen(config.app.port, () => {
  console.log(`${config.app.name} running on port ${config.app.port}`);
});
