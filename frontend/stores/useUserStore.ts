import { defineStore } from 'pinia';
import type { LoginData } from '~/types/user';

export const useUserStore = defineStore('user', {
  state: () => ({
    loginData: {
      email: '',
      password: '',
      remember: true,
    } as LoginData,
  }),
  actions: {
    async login() {
      try {
        const { login } = useSanctumAuth();
        await login(this.loginData, false);
      } catch (err) {
        console.error('Login failed:', err);
      }
    },
  },
});
