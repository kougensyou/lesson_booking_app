export const getLoginInfoAPI = () => {
  const base = useApiBase()
  return useFetch(`${base}/api/login_info`)
}

export const loginAPI = (data: any) => {
  return useFetch('/oauth/token', {
    method: 'POST',
    body: data,
    headers: { 'Content-Type': 'application/json' }
  })
}
