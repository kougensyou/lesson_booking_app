export const useApiBase = () => {
  const config = useRuntimeConfig()
  return import.meta.server ? config.apiBaseServer : config.public.apiBaseBrowser
}