// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: '2025-05-15',
  devtools: { enabled: true },
  modules: ['@pinia/nuxt'],
  vite: {
    server: {
      allowedHosts: ['host.docker.internal'],
      watch: {
        usePolling: true,
      },
      hmr: {
        clientPort: 80
      },
      proxy: {
        '/api': {
          target: 'http://lesson_booking_nginx:9000',
          changeOrigin: true,
          secure: false,
        }
      }
    }
  },
  runtimeConfig: {
    public: {
      apiBase: process.env.NUXT_PUBLIC_API_BASE
    }
  }
})

