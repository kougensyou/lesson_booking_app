import { defineStore } from 'pinia'
import { getLoginInfoAPI, loginAPI } from '../composables/api/user'


export const useUserStore = defineStore('user', {
  state: () => ({
    url: '',
    email: '',
    password: '',
    common: undefined as any,
    authData: undefined as any
  }),
  getters: {
  },
  actions: {
    async getLoginInfo() {
      try {
        const res = await getLoginInfoAPI();
        console.log(res.data.value);
        this.authData = JSON.stringify(res.data.value);
      } catch (err) {
        throw err
      }
    },

    async login() {
      if (!this.authData) return

      const parsed = JSON.parse(this.authData);
      parsed.data.username = this.email
      parsed.data.password = this.password

      try {
        const res = await loginAPI(parsed.data)
        console.log(res.data)
      } catch (err) {
        console.error(err)
      }
    }
  }
})