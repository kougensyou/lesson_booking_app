export interface LoginData {
  email: string;
  password: string;
  remember: boolean;
}

export interface PasswordData {
  currentPassword: string;
  newPassword: string;
  newPasswordConfirmation: string;
}
