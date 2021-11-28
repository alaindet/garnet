export const environment = {
  development: process.env?.GARNET_APP_ENV === 'development',
  production: process.env?.GARNET_APP_ENV === 'production',
};
