import { defineStore } from 'pinia'
import { getLoginInfoAPI, loginAPI } from '~/composables/api/useUser';
import type { LoginData, LoginInfoResponse } from '~/types/user';

export const useUserStore = defineStore('user', {
  state: () => ({
    loginData: {
      grant_type: '',
      client_id: 0,
      client_secret: '',
      scope: '',
      username: '',
      password: '',
    } as LoginData
  }),
  getters: {
  },
  actions: {
    async fetchLoginInfo() {
      const { data } = await getLoginInfoAPI();
      this.loginData.grant_type = (data.value as LoginInfoResponse)?.grant_type || '';
      this.loginData.client_id = (data.value as LoginInfoResponse)?.client_id || 0;
      this.loginData.client_secret = (data.value as LoginInfoResponse)?.client_secret || '';
      this.loginData.scope = (data.value as LoginInfoResponse)?.scope || '';
      console.log('Login info fetched:', this.loginData);
    },
    async login() {
      try {
        const res = await loginAPI(this.loginData)
        console.log(res.data)
      } catch (err) {
        console.error(err)
      }
    }
  }
})