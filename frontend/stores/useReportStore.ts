import { defineStore } from 'pinia';

export const useReportStore = defineStore('report', {
  state: () => ({
    // Report Input Form
    title: '',
    email: '',
    contents: '',
    // Toast
    toastMessage: '' as string,
    toastVisible: false as boolean,
    toastTimeout: 0 as number,
    // Loading
    isReportLoading: false as boolean,
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
    setToastMessage() {
      const { t } = useI18n();
      this.toastMessage = t('report.toastMessage');
    },
    initializeReport() {
      this.title = '';
      this.email = '';
      this.contents = '';
    },
    async sendReportApi() {
      this.isReportLoading = true;
      try {
        const { data, error } = await useSanctumFetch('/api/send_report', {
          method: 'POST',
          body: {
            title: this.title,
            email: this.email,
            contents: this.contents,
          },
        });
        if (error.value) {
          throw createError({
            statusCode: error.value.statusCode,
            message: error.value.message,
            data: error.value.data,
          });
        }
        // console.log('sendReportApi:', data.value);
        this.initializeReport();
        this.initializeErrors();
        this.isReportLoading = false;
        this.openToast(2500);
      } catch (err: any) {
        console.error('Error sendReportApi:', err.data);
        this.isReportLoading = false;
        if (err.statusCode === 422) {
          this.setErrors(err.data.errors);
        }
        throw err;
      }
    },
    openToast(ms = 2500) {
      this.toastVisible = true;
      clearTimeout(this.toastTimeout);
      this.toastTimeout = window.setTimeout(
        () => (this.toastVisible = false),
        ms
      );
    },
  },
});
