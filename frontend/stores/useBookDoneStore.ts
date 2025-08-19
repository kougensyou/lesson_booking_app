import { defineStore } from 'pinia';
import { useI18n } from 'vue-i18n';

export const useBookDoneStore = defineStore('bookDone', {
  state: () => {
    const { t } = useI18n();
    return {
      instructorMessage: t('bookDone.instructorMessage'),
    };
  },
  actions: {},
});
