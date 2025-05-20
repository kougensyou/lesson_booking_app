
import path from 'path'
import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'ts'),
      vue: 'vue/dist/vue.esm-bundler.js',
    },
  },
  base: '/',
  plugins: [vue()],
  css: {
    devSourcemap: true,
  },
  build: {
    rollupOptions: {
      input: {
        main: path.resolve(__dirname, 'index.html'),
      }
    }
  },
  server: {
    host: true,
    port: 8000,
    watch: {
      usePolling: true
    },
    proxy: {
      '^/oauth': {
        target: 'http://nginx:80',
        changeOrigin: true
      },
      '^/api': {
        target: 'http://nginx:80',
        changeOrigin: true
      }
    }
  }
})