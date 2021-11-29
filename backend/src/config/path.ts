import { join } from 'path';

const ROOT = join(__dirname, '..', '..');

export const path = {
  root: ROOT,
  database: join(ROOT, 'database'),
  databaseMigrations: join(ROOT, 'database', 'migrations'),
  databaseSeeds: join(ROOT, 'database', 'seeds'),
};
