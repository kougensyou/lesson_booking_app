import { defineStore } from 'pinia';

export const useReportStore = defineStore('report', {
  state: () => ({
    subject: '',
    email: '',
    message: '',
  }),
  actions: {
    async sendReport() {
      try {
        const { data } = await useSanctumFetch('/api/send_report', {
          method: 'POST',
          body: {
            subject: this.subject,
            email: this.email,
            message: this.message,
          },
        });
        console.log('sendReport fetched:', data.value);
      } catch (err) {
        console.error('Error fetching sendReport data:', err);
      }
    },
  },
});
