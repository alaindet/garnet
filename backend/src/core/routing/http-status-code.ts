export enum HttpStatusCode {

  // 2xx: Successful response
  Ok = 200,
  Created = 201,
  NoContent = 204,

  // 3xx: Redirect messages
  MovedPermanently = 301,
  Found = 302,

  // 4xx: Client error responses
  BadRequest = 400,
  Unauthorized = 401,
  Forbidden = 403,
  NotFound = 404,
  MethodNotAllowed = 405,
  Conflict = 409,
  TooManyRequests = 429,

  // 5xx: Server error responses
  InternalServerError = 500,
  ServiceUnavailable = 503,
}
