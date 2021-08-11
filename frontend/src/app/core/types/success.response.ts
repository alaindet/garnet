export interface SuccessResponse<T = any> {
  message: string;
  data: T;
}