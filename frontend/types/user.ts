export interface LoginData {
  email: string;
  password: string;
  remember: boolean;
}

export interface PasswordData {
  current_password: string;
  new_password: string;
  new_password_confirmation: string;
}

export interface User {
  id: number;
  name: string;
  email: string;
  zip_code: string;
  address: string;
  birth_date: string;
  tel_no: string;
  image_path: string;
  image_url: string;
}
