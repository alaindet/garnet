import knex from 'knex';

import config from '@/config';

export const database = knex({
  client: 'pg',
  connection: config.database,
  // migrations: {
  //   directory: config.path.databaseMigrations,
  // },
  // seeds: {
  //   directory: config.path.databaseSeeds,
  // },
  // useNullAsDefault: true,
});
