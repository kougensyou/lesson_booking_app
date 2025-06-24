const selectedLocale = 'ja';

export default defineNuxtConfig({
  compatibilityDate: '2025-05-15',
  devtools: { enabled: true },
  ssr: false,
  modules: ['@pinia/nuxt', '@nuxtjs/tailwindcss', '@nuxtjs/i18n'],
  i18n: {
    locales: [
      { code: 'ja', name: '日本語', file: 'ja.json' },
      { code: 'en', name: 'English', file: 'en.json' },
    ],
    lazy: true,
    langDir: '../locales/',
    defaultLocale: selectedLocale,
    strategy: 'no_prefix',
    bundle: {
      optimizeTranslationDirective: false,
    },
  },
  app: {
    head: {
      meta: [
        { name: 'viewport', content: 'width=device-width, initial-scale=1.0' },
      ],
      link: [
        { rel: 'icon', type: 'image/x-icon', href: '/lesson-booking-logo.png' },
        {
          rel: 'stylesheet',
          href: 'https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined',
        },
      ],
    },
  },
  vite: {
    server: {
      allowedHosts: ['frontend'],
      watch: {
        usePolling: true,
      },
      hmr: {
        clientPort: 80,
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
        },
      },
    },
  },
  runtimeConfig: {
    apiBaseServer: process.env.NUXT_API_BASE_SERVER,
    public: {
      apiBaseBrowser: process.env.NUXT_API_BASE_BROWSER,
    },
  },
});
