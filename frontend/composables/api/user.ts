export const getLoginInfoAPI = () => {
  const config = useRuntimeConfig()
  const base = import.meta.server ? config.apiBaseServer : config.public.apiBase
  return useFetch(`${base}/api/login_info`, { server: true })
}

export const loginAPI = (data: any) => {
  return useFetch('/oauth/token', {
    method: 'POST',
    body: data,
    headers: { 'Content-Type': 'application/json' }
  })
}
