import type { LoginData } from '~/types/user';

export const getLoginInfoAPI = () => {
  const base = useApiBase();
  return useFetch(`${base}/api/login_info`);
};

export const loginAPI = (loginData: LoginData) => {
  const base = useApiBase();
  return useFetch(`${base}/oauth/token`, {
    method: 'POST',
    body: loginData,
    headers: { 'Content-Type': 'application/json' },
  });
};
