import { defineStore } from 'pinia';
import { loginAPI } from '~/composables/api/useUser';
import type { LoginData, TokenData } from '~/types/user';

export const useUserStore = defineStore('user', {
  state: () => ({
    loginData: {
      username: '',
      password: '',
    } as LoginData,
    tokenData: {
      access_token: '',
      token_type: '',
      expires_in: 0,
      refresh_token: '',
    } as TokenData,
  }),
  actions: {
    async login(router: any) {
      try {
        const res = await loginAPI(this.loginData);
        console.log(res);
        const tokenInfo = res.data.value as TokenData;
        this.tokenData.access_token = tokenInfo.access_token || '';
        this.tokenData.token_type = tokenInfo.token_type || '';
        this.tokenData.expires_in = tokenInfo.expires_in || 0;
        this.tokenData.refresh_token = tokenInfo.refresh_token || '';
        console.log('token info fetched:', this.tokenData);
        if (this.tokenData.access_token) {
          console.log('Login successful:', this.tokenData);
          router.push('/home');
        }
      } catch (err) {
        console.error(err);
      }
    },
  },
});
