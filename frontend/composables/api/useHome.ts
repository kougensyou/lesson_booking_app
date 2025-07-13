export const getHomeDataAPI = (access_token: string) => {
  const base = useApiBase();
  return useFetch(`${base}/api/get_home_data`, {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json',
      Authorization: `Bearer ${access_token}`,
      credentials: 'include',
    },
  });
};
