import express from 'express';
import mysql from 'mysql';

const app = express();

const db = mysql.createConnection({
  host : process.env.GARNET_DB_HOST,
  user : process.env.GARNET_DB_USER,
  password : process.env.GARNET_DB_PASSWORD,
  database : process.env.GARNET_DB_NAME,
});

db.query('SELECT * FROM `courses` LIMIT 50', (error, results, fields) => {
  if (error) throw error;
  console.log('Results', results);
});

app.get('/', (req, res) => {
  res.json({
    GARNET_SECURITY_JWT_SECRET: process.env.GARNET_SECURITY_JWT_SECRET,
  });
});

app.listen(3001, () => {
  console.log(`server running on port 3001`);
});
