import express from 'express';
import knex from 'knex';

const app = express();

const dbConfig = {
  host: process.env.GARNET_DB_HOST,
  database: process.env.GARNET_DB_NAME,
  user: process.env.GARNET_DB_USER,
  password: process.env.GARNET_DB_PASSWORD,
  port: process.env.GARNET_DB_PORT,
};

const db = knex({
  client: 'pg',
  connection: {
    host: dbConfig.host,
    port: +(dbConfig.port ?? 5432),
    user: dbConfig.user,
    password: dbConfig.password,
    database: dbConfig.database,
  },
  // migrations: {
  //   directory: './database/migrations',
  // },
  // seeds: {
  //   directory: './database/seeds',
  // },
  // useNullAsDefault: true,
});

app.get('/', async (req, res) => {
  const courses = await db.raw('SELECT * FROM "public"."courses"');
  res.json({
    courses: courses.rows,
  });
});

app.listen(3001, () => {
  console.log(`server running on port 3001`);
});
