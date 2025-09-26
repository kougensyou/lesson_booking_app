import { defineStore } from 'pinia';
import type { LoginData, PasswordData, User } from '~/types/user';
import { useI18n } from 'vue-i18n';

export const useUserStore = defineStore('user', {
  state: () => ({
    loginData: {
      email: '',
      password: '',
      remember: true,
    } as LoginData,
    passwordData: {
      currentPassword: '',
      newPassword: '',
      newPasswordConfirmation: '',
    } as PasswordData,
    toastMessage: '' as string,
    toastVisible: false as boolean,
    toastTimeout: 0 as number,
    user: {} as User,
    fileData: null as File | null,
    emailForPasswordReset: '' as string,
    errors: {} as any,
  }),
  actions: {
    initializeErrors() {
      this.errors = {};
    },
    setErrors(errors: any) {
      this.errors = errors;
    },
    async loginApi() {
      try {
        const { user, login } = useSanctumAuth();
        await login(this.loginData);
        this.user = user.value as User;
        this.initializeLoginData();
      } catch (err: any) {
        console.error('Login failed:', err.data);
        if (err.statusCode === 422) {
          this.setErrors(err.data.errors);
          return;
        }
        throw err;
      }
    },
    async logout() {
      try {
        const { logout } = useSanctumAuth();
        await logout();
        this.initializeUser();
      } catch (err: any) {
        console.error('Logout failed:', err.data);
        throw err;
      }
    },
    async updatePasswordApi() {
      try {
        const { data, error } = await useSanctumFetch('/api/update_password', {
          method: 'POST',
          body: {
            password_data: this.passwordData,
          },
        });
        if (error.value) {
          throw createError({
            statusCode: error.value.statusCode,
            message: error.value.message,
            data: error.value.data,
          });
        }
        console.log('updatePassword fetched:', data.value);
        this.initializeErrors();
        this.initializePasswordData();
        this.openToast(2500);
      } catch (err: any) {
        console.error('Update password failed:', err.data);
        if (err.statusCode === 422) {
          this.setErrors(err.data.errors);
          return;
        }
        throw err;
      }
    },
    async updateUserApi() {
      const formData = new FormData();
      if (this.fileData) {
        formData.append('image', this.fileData);
      }
      formData.append('user', JSON.stringify(this.user));
      //console.log('updateUser user: ' + JSON.stringify(this.user));
      try {
        const { data } = await useSanctumFetch('/api/update_user', {
          method: 'POST',
          body: formData,
        });
        this.user = data.value as User;
        //console.log('updateUser user: ' + JSON.stringify(this.user));
        console.log('updateUser fetched:', data.value);
        this.openToast(2500);
      } catch (err: any) {
        console.error('Update user failed:', err.data);
      }
    },
    async sendPasswordResetMailApi() {
      try {
        const { data, error } = await useSanctumFetch(
          '/api/send_password_reset_mail',
          {
            method: 'POST',
            body: {
              email: this.emailForPasswordReset,
            },
          }
        );
        if (error.value) {
          throw createError({
            statusCode: error.value.statusCode,
            message: error.value.message,
            data: error.value.data,
          });
        }
        console.log('sendPasswordResetMail fetched:', data.value);
        this.openToast(2500);
      } catch (err: any) {
        console.error('sendPasswordResetMail failed:', err.data);
        if (err.statusCode === 422) {
          this.setErrors(err.data.errors);
          return;
        }
        throw err;
      }
    },
    initializeLoginData() {
      this.loginData.email = '';
      this.loginData.password = '';
      this.loginData.remember = true;
    },
    initializePasswordData() {
      this.passwordData.currentPassword = '';
      this.passwordData.newPassword = '';
      this.passwordData.newPasswordConfirmation = '';
    },
    initializeUser() {
      this.user = {} as User;
      this.fileData = null;
    },
    setUser(user: User) {
      this.user = user;
    },
    setToastMessageForPassword() {
      const { t } = useI18n();
      this.toastMessage = t('passwordChange.toastMessage');
    },
    setToastMessageForPasswordReset() {
      const { t } = useI18n();
      this.toastMessage = t('passwordReset.toastMessage');
    },
    setToastMessageForUser() {
      const { t } = useI18n();
      this.toastMessage = t('userUpdate.toastMessage');
    },
    openToast(ms = 2500) {
      this.toastVisible = true;
      clearTimeout(this.toastTimeout);
      this.toastTimeout = window.setTimeout(
        () => (this.toastVisible = false),
        ms
      );
    },
    onFileChange(e: Event) {
      const file = (e.target as HTMLInputElement).files?.[0];
      if (file) {
        this.fileData = file;
        this.user.image_url = URL.createObjectURL(file);
      }
    },
  },
});
