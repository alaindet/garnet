export interface Response<T = any> {
  data: T;
  message: string;
}

export interface ErrorResponse {
  error: {
    message: string;
    [other: string]: any;
  }
}