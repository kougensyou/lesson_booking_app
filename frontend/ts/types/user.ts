export interface User {
  user_id: string;
  user_name: string;
  user_type: string;
  email: string;
  email_confirmation: string;
  del_flg: number;
}

export interface Users {
  id: string;
  user_id: string;
  user_name: string;
  email: string;
  user_type_name: string;
  del_flg: number;
}
