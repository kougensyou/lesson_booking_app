import { defineStore } from 'pinia';
import type { LessonDetail } from '~/types/lessonDetail';

export const useLessonDetailStore = defineStore('lessonDetail', {
  state: () => ({
    lessonId: '',
    lessonDetail: {} as LessonDetail,
    isDialogOpen: false as boolean,
  }),
  actions: {
    setLessonId(lessonId: string) {
      this.lessonId = lessonId;
    },
    openDialog() {
      this.isDialogOpen = true;
    },
    closeDialog() {
      this.isDialogOpen = false;
    },
    async getLessonDetailApi() {
      try {
        const { data } = await useSanctumFetch('/api/get_lesson_detail', {
          method: 'GET',
          query: {
            lesson_id: this.lessonId,
          },
        });
        this.lessonDetail = data.value as LessonDetail;
        console.log('lesson detail data fetched:', this.lessonDetail);
      } catch (err) {
        console.error('Error fetching lesson detail data:', err);
      }
    },
    async bookLessonApi() {
      try {
        const { data } = await useSanctumFetch('/api/book_lesson', {
          method: 'POST',
          body: {
            lesson_id: this.lessonId,
          },
        });
        this.closeDialog();
        console.log('bookLesson fetched:', data.value);
      } catch (err) {
        console.error('Error fetching bookLesson data:', err);
      }
    },
  },
});
