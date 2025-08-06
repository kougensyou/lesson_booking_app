import { defineStore } from 'pinia';
import type {
  FavoriteStudio,
  LessonBookingData,
  Studio,
  LessonCategory,
} from '~/types/lessonBooking';

export const useLessonBookingStore = defineStore('lessonBooking', {
  state: () => ({
    favoriteStudioList: [] as FavoriteStudio[],
    studioList: [] as Studio[],
    lessonCategoryList: [] as LessonCategory[],
  }),
  actions: {
    async getLessonBookingData() {
      try {
        const { data } = await useSanctumFetch('/api/get_lesson_booking_data', {
          method: 'GET',
        });
        const lessonBookingData = data.value as LessonBookingData;
        this.favoriteStudioList = lessonBookingData.favorite_studio_list;
        // this.studioList = lessonBookingData.studio_list;
        // this.lessonCategoryList = lessonBookingData.lesson_category_list;
        console.log('lesson booking data fetched:', lessonBookingData);
      } catch (err) {
        console.error('Error fetching lesson booking data:', err);
      }
    },
  },
});
