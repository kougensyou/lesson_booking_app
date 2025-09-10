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
  }),
  actions: {
    async login() {
      try {
        const { user, login } = useSanctumAuth();
        await login(this.loginData);
        this.user = user.value as User;
        this.initializeLoginData();
      } catch (err) {
        console.error('Login failed:', err);
      }
    },
    async logout() {
      try {
        const { logout } = useSanctumAuth();
        await logout();
      } catch (err) {
        console.error('Logout failed:', err);
      }
    },
    async updatePassword() {
      try {
        const { data } = await useSanctumFetch('/api/update_password', {
          method: 'POST',
          body: {
            password_data: this.passwordData,
          },
        });
        console.log('updatePassword fetched:', data.value);
        this.initializePasswordData();
        this.openToast(2500);
      } catch (err) {
        console.error('Update password failed:', err);
      }
    },
    async updateUser() {
      if (!this.fileData) return;
      const formData = new FormData();
      formData.append('image', this.fileData);
      formData.append('user', JSON.stringify(this.user));
      try {
        const { data } = await useSanctumFetch('/api/update_user', {
          method: 'POST',
          body: formData,
        });
        console.log('updateUser fetched:', data.value);
        this.openToast(2500);
      } catch (err) {
        console.error('Update user failed:', err);
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
    setToastMessageForPassword() {
      const { t } = useI18n();
      this.toastMessage = t('passwordChange.toastMessage');
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
