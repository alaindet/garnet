import express from 'express';
import { sql, createPool } from 'slonik';

const app = express();

const dbConfig = {
  host: process.env.GARNET_DB_HOST,
  database: process.env.GARNET_DB_NAME,
  user: process.env.GARNET_DB_USER,
  password: process.env.GARNET_DB_PASSWORD,
  port: process.env.GARNET_DB_PORT,
};

// TODO: Does not work!
(async () => {
  const connectionString = (
    'postgresql://' +
    `${dbConfig.host}:` +
    `${dbConfig.port}/` +
    `${dbConfig.database}?` +
    `user=${dbConfig.user}&` +
    `password=${dbConfig.password}`
  );

  const pool = createPool(connectionString);
  const sqlQuery = sql`SELECT now()::timestamp`;
  pool.connect(async connection => {
    const result = await connection.query(sqlQuery);
    console.log(result);
  });
})();

app.get('/', (req, res) => {
  res.json({
    GARNET_SECURITY_JWT_SECRET: process.env.GARNET_SECURITY_JWT_SECRET,
  });
});

app.listen(3001, () => {
  console.log(`server running on port 3001`);
});
