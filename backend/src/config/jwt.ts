export const jwt = {
  secret: process.env.GARNET_SECURITY_JWT_SECRET,
  issuer: process.env.GARNET_SECURITY_JWT_ISSUER,
  expiresIn: process.env.GARNET_SECURITY_JWT_EXPIRES_IN,
};
