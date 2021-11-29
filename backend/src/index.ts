import express from 'express';

// import { database } from './core';
import config from './config';

import { coursesRoutes } from '@/features/courses';

const app = express();

app.use(coursesRoutes);

// app.get('/', async (req, res) => {
//   const result = await database.raw('SELECT * FROM "public"."courses"');
//   const courses = result.rows;
//   res.json({ courses });
// });

app.use();

app.listen(config.app.port, () => {
  console.log(`server running on port 3001`);
});
