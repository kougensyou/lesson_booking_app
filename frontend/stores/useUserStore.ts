import { defineStore } from 'pinia';
import { getLoginDataAPI, loginAPI } from '~/composables/api/useUser';
import type { LoginData, LoginInfoResponse, TokenData } from '~/types/user';

export const useUserStore = defineStore('user', {
  state: () => ({
    loginData: {
      grant_type: '',
      client_id: 0,
      client_secret: '',
      scope: '',
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
    async getLoginData() {
      try {
        const { data } = await getLoginDataAPI();
        const loginInfo = data.value as LoginInfoResponse;
        this.loginData.grant_type = loginInfo.grant_type || '';
        this.loginData.client_id = loginInfo.client_id || 0;
        this.loginData.client_secret = loginInfo.client_secret || '';
        this.loginData.scope = loginInfo.scope || '';
        console.log('Login info fetched:', this.loginData);
      } catch (err) {
        console.error('Error fetching login info:', err);
      }
    },
    async login() {
      try {
        const res = await loginAPI(this.loginData);
        const tokenInfo = res.data.value as TokenData;
        this.tokenData.access_token = tokenInfo.access_token || '';
        this.tokenData.token_type = tokenInfo.token_type || '';
        this.tokenData.expires_in = tokenInfo.expires_in || 0;
        this.tokenData.refresh_token = tokenInfo.refresh_token || '';
        console.log('token info fetched:', this.tokenData);
      } catch (err) {
        console.error(err);
      }
    },
  },
});
