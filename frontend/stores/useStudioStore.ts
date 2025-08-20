import { defineStore } from 'pinia';
import type {
  FavoriteStudio,
  LessonBookingData,
  Studio,
} from '~/types/lessonBooking';

export const useStudioStore = defineStore('studio', {
  state: () => ({
    favoriteStudioList: [] as FavoriteStudio[],
    studioList: [] as Studio[],
  }),
  actions: {
    async getStudioData() {
      try {
        const { data } = await useSanctumFetch('/api/get_studio_data', {
          method: 'GET',
        });
        const lessonBookingData = data.value as LessonBookingData;
        this.favoriteStudioList = lessonBookingData.favorite_studio_list;
        this.studioList = lessonBookingData.studio_list;
        console.log('lesson booking data fetched:', lessonBookingData);
      } catch (err) {
        console.error('Error fetching lesson booking data:', err);
      }
    },
  },
});
