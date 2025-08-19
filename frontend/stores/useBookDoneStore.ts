import { defineStore } from 'pinia';
import { useI18n } from 'vue-i18n';
import type { Lesson } from '~/types/common';
import type { BookDoneData } from '~/types/bookDone';

export const useBookDoneStore = defineStore('bookDone', {
  state: () => {
    const { t } = useI18n();
    return {
      instructorMessage: t('bookDone.instructorMessage'),
      sameStudioLessonList: Array<Lesson>(),
    };
  },
  actions: {
    async getBookDoneData(studioId: string) {
      try {
        const { data } = await useSanctumFetch('/api/get_book_done_data', {
          method: 'GET',
          query: {
            studio_id: studioId,
          },
        });
        const bookDoneData = data.value as BookDoneData;
        this.sameStudioLessonList =
          bookDoneData.same_studio_lesson_list as Lesson[];
        console.log('book done data fetched:', bookDoneData);
      } catch (err) {
        console.error('Error fetching book done data:', err);
      }
    },
  },
});
