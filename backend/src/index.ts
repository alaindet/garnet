import express from 'express';

import config from '@/config';
import { coursesRoutes } from '@/features/courses';
// Add imports here...

const app = express();

app.use(coursesRoutes);
// Add routes here...

app.listen(config.app.port, () => {
  console.log(`${config.app.name} running on port ${config.app.port}`);
});
