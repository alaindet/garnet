export const cors = {
  origin: process.env.GARNET_SECURITY_CORS_ORIGIN,
  methods: process.env.GARNET_SECURITY_CORS_METHODS,
  maxAge: process.env.GARNET_SECURITY_CORS_MAX_AGE,
  headers: process.env.GARNET_SECURITY_CORS_HEADERS,
};
