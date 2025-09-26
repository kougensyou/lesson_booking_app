import { defineStore } from 'pinia';

export const useReportStore = defineStore('report', {
  state: () => ({
    title: '',
    email: '',
    contents: '',
    toastMessage: '' as string,
    toastVisible: false as boolean,
    toastTimeout: 0 as number,
  }),
  actions: {
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
        console.log('sendReport fetched:', data.value);
        this.initializeReport();
        this.openToast(2500);
      } catch (err: any) {
        console.error('Error fetching sendReport data:', err.data);
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
