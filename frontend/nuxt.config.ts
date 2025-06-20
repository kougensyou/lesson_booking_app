// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2025-05-15',
  devtools: { enabled: true },
  ssr: false,
  modules: ['@pinia/nuxt','@nuxtjs/tailwindcss'],
  vite: {
    server: {
      allowedHosts: ['frontend'],
      watch: {
        usePolling: true,
      },
      hmr: {
        clientPort: 80
      },
      proxy: {
        '/api': {
          target: 'http://nginx:9000',
          changeOrigin: true,
          secure: false,
        },
        '/oauth': {
          target: 'http://nginx:9000',
          changeOrigin: true,
          secure: false,
        }
      }
    }
  },
  runtimeConfig: {
    apiBaseServer: process.env.NUXT_API_BASE_SERVER,
    public: {
      apiBaseBrowser: process.env.NUXT_API_BASE_BROWSER
    }
  }
})

