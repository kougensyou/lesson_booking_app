export interface LoginData {
  grant_type: string;
  client_id: number;
  client_secret: string;
  scope: string;
  username: string;
  password: string;
}

export interface LoginInfoResponse {
  grant_type: string;
  client_id: number;
  client_secret: string;
  scope: string;
}

export interface TokenData {
  access_token: string;
  token_type: string;
  expires_in: number;
  refresh_token: string;
}
