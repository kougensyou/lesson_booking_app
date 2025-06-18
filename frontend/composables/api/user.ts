export const getLoginInfoAPI = () => {
  const config = useRuntimeConfig()
  return useFetch(`${config.public.apiBase}/api/login_info`, { server: true })
}

export const loginAPI = (data: any) => {
  return useFetch('/oauth/token', {
    method: 'POST',
    body: data,
    headers: { 'Content-Type': 'application/json' }
  })
}
