import type { LoginData } from '~/types/user';

export const loginAPI = (loginData: LoginData) => {
  const base = useApiBase();
  return useFetch(`${base}/api/login`, {
    method: 'POST',
    body: loginData,
    headers: { 'Content-Type': 'application/json' },
    credentials: 'include',
  });
};
