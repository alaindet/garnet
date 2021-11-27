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

(async () => {
  const result = await db.raw('SELECT * FROM "public"."courses"');
  console.log(result.rows);
})();

app.get('/', (req, res) => {
  res.json({
    GARNET_SECURITY_JWT_SECRET: process.env.GARNET_SECURITY_JWT_SECRET,
  });
});

app.listen(3001, () => {
  console.log(`server running on port 3001`);
});
