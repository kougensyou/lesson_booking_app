import { defineStore } from 'pinia'

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
    setAuthData(data: any) {
      console.log('Setting auth data:', data);
      //this.authData = JSON.stringify(data);
    },
    // async login() {
    //   if (!this.authData) return

    //   const parsed = JSON.parse(this.authData);
    //   parsed.data.username = this.email
    //   parsed.data.password = this.password

    //   try {
    //     const res = await loginAPI(parsed.data)
    //     console.log(res.data)
    //   } catch (err) {
    //     console.error(err)
    //   }
    // }
  }
})