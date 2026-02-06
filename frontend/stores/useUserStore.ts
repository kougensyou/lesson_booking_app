import { defineStore } from 'pinia';
import type { LoginData, PasswordData, User } from '~/types/user';
import { useI18n } from 'vue-i18n';

export const useUserStore = defineStore('user', {
  state: () => ({
    isUserLoading: false as boolean,
    // Login Data
    loginData: {
      email: '',
      password: '',
      remember: true,
    } as LoginData,
    // Password Data
    passwordData: {
      current_password: '',
      new_password: '',
      new_password_confirmation: '',
    } as PasswordData,
    // User Update Data
    user: {} as User,
    fileInput: null as HTMLInputElement | null,
    fileData: null as File | null,
    formData: new FormData(),
    // Password Reset Data
    emailForPasswordReset: '' as string,
    // Toast
    toastMessage: '' as string,
    toastVisible: false as boolean,
    toastTimeout: 0 as number,
    // Errors
    errors: {} as any,
  }),
  actions: {
    initializeErrors() {
      this.errors = {};
    },
    setErrors(errors: any) {
      this.errors = errors;
    },
    // Login and updates the user data in the store.
    async loginApi() {
      this.isUserLoading = true;
      try {
        const { user, login } = useSanctumAuth();
        await login(this.loginData);
        this.user = user.value as User;
        this.isUserLoading = false;
        this.initializeLoginData();
      } catch (err: any) {
        console.error('Error loginApi:', err.data);
        this.isUserLoading = false;
        if (err.statusCode === 422) {
          this.setErrors(err.data.errors);
          return;
        }
        throw err;
      }
    },
    // Logout and initialize user data in the store.
    async logout() {
      this.isUserLoading = true;
      try {
        const { logout } = useSanctumAuth();
        await logout();
        this.isUserLoading = false;
        this.initializeUser();
      } catch (err: any) {
        console.error('Error logout:', err.data);
        this.isUserLoading = false;
        throw err;
      }
    },
    async updatePasswordApi() {
      this.isUserLoading = true;
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
        console.log('updatePasswordApi:', data.value);
        this.initializeErrors();
        this.initializePasswordData();
        this.isUserLoading = false;
        this.openToast(2500);
      } catch (err: any) {
        console.error('Error updatePasswordApi:', err.data);
        this.isUserLoading = false;
        if (err.statusCode === 422) {
          this.setErrors(err.data.errors);
          return;
        }
        throw err;
      }
    },
    async updateUserApi() {
      this.isUserLoading = true;
      if (this.fileData) {
        this.formData.append('image', this.fileData);
      }
      this.formData.append('user', JSON.stringify(this.user));
      // console.log('updateUser user: ' + JSON.stringify(this.user));
      try {
        const { data, error } = await useSanctumFetch('/api/update_user', {
          method: 'POST',
          body: this.formData,
        });
        if (error.value) {
          throw createError({
            statusCode: error.value.statusCode,
            message: error.value.message,
            data: error.value.data,
          });
        }
        this.user = data.value as User;
        // console.log('updateUserApi:', data.value);
        this.isUserLoading = false;
        this.initializeErrors();
        this.openToast(2500);
      } catch (err: any) {
        console.error('Error updateUserApi:', err.data);
        this.isUserLoading = false;
        if (err.statusCode === 422) {
          this.initializeErrors();
          this.setErrors(err.data.errors);
          return;
        }
        throw err;
      }
    },
    async sendPasswordResetMailApi() {
      this.isUserLoading = true;
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
        // console.log('sendPasswordResetMailApi:', data.value);
        this.initializeErrors();
        this.isUserLoading = false;
        this.openToast(2500);
      } catch (err: any) {
        console.error('Error sendPasswordResetMailApi:', err.data);
        this.isUserLoading = false;
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
      this.passwordData.current_password = '';
      this.passwordData.new_password = '';
      this.passwordData.new_password_confirmation = '';
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
    /**
     * Called when the user selects a new file for their profile picture.
     * Updates the store with the new file and sets the user's image_url
     * to the URL of the file.
     */
    onFileChange(e: Event) {
      const file = (e.target as HTMLInputElement).files?.[0];
      if (file) {
        this.fileData = file;
        this.user.image_url = URL.createObjectURL(file);
      }
    },
  },
});
