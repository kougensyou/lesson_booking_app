const selectedLocale = 'ja';

export default defineNuxtConfig({
  compatibilityDate: '2025-05-15',
  devtools: { enabled: true },
  ssr: false,
  modules: [
    '@pinia/nuxt',
    '@nuxtjs/tailwindcss',
    '@nuxtjs/i18n',
    'nuxt-auth-sanctum',
  ],
  sanctum: {
    mode: 'cookie',
    baseUrl: process.env.NUXT_PUBLIC_SANCTUM_BASE_URL,
    userStateKey: 'sanctum.user.identity',
    redirectIfAuthenticated: false,
    redirectIfUnauthenticated: false,
    endpoints: {
      csrf: '/sanctum/csrf-cookie',
      login: '/api/login',
      logout: '/api/logout',
      user: '/api/user',
    },
    csrf: {
      cookie: 'XSRF-TOKEN',
      header: 'X-XSRF-TOKEN',
    },
    client: {
      retry: false,
      initialRequest: false,
    },
    redirect: {
      keepRequestedRoute: true,
      onLogin: '/home',
      onLogout: '/',
      onAuthOnly: '/',
      onGuestOnly: '/',
    },
    globalMiddleware: {
      enabled: false,
      allow404WithoutAuth: true,
    },
    logLevel: 5,
    appendPlugin: false,
  },
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
    },
  },
});
