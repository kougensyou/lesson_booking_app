import { defineStore } from 'pinia';
import type { LessonDetail } from '~/types/lessonDetail';

export const useLessonDetailStore = defineStore('lessonDetail', {
  state: () => ({
    lessonId: '',
    lessonDetail: {} as LessonDetail,
  }),
  actions: {
    setLessonId(lessonId: string) {
      this.lessonId = lessonId;
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
  },
});
