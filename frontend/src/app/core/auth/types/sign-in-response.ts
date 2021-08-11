export interface SignInResponse {
  message: string;
  data: {
    jwt: string;
  };
}