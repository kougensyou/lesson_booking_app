import javascriptObfuscator from 'vite-plugin-javascript-obfuscator';
export default defineNuxtConfig({
  compatibilityDate: '2025-05-15',
  devtools: { enabled: true },
  ssr: false,
  sourcemap: { client: false, server: false },
  modules: [
    '@pinia/nuxt',
    'pinia-plugin-persistedstate/nuxt',
    '@nuxtjs/tailwindcss',
    '@nuxtjs/i18n',
    'nuxt-auth-sanctum',
    'vue3-carousel-nuxt',
  ],
  css: ['v-calendar/dist/style.css'],
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
      { code: 'en', language: 'en-US', file: 'en.json' },
      // { code: 'ja', language: 'ja-JP', file: 'ja.json' },
    ],
    langDir: 'locales/',
    defaultLocale: 'en',
    strategy: 'no_prefix',
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
    plugins: [
      javascriptObfuscator({
        apply: 'build',
        include: ['**/*.js'],
        options: {
          compact: true,
          controlFlowFlattening: true,
        },
      }),
    ],
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
