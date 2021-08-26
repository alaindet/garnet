export type TimestampString = string;

export interface JwtDecodedInfo {
  exp: TimestampString;
  iat: TimestampString;
  iss: string;
  nbf: TimestampString;
  sub: number; // User ID
  [key: string]: any; // Custom claims
}
