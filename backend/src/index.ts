import express from 'express';

// import { database } from '@/core';
import config from '@/config';

const app = express();

// app.get('/', async (req, res) => {
//   const result = await database.raw('SELECT * FROM "public"."courses"');
//   const courses = result.rows;
//   res.json({ courses });
// });

app.listen(config.app.port, () => {
  console.log(`server running on port 3001`);
});
