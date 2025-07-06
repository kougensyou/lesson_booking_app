import { defineStore } from 'pinia';
import { getHomeDataAPI } from '~/composables/api/useHome';
import type { Lesson, Info, LessonBooking } from '~/types/home';

export const useHomeStore = defineStore('home', {
  state: () => ({
    nextLessonList: [] as Lesson[],
    lessonListThisMonth: [] as LessonBooking[],
    sliderInfoList: [] as Info[],
    gridInfoList: [] as Info[],
  }),
  actions: {
    async getHomeData(access_token: string) {
      try {
        const { data } = await getHomeDataAPI(access_token);
        // this.nextLessonList = data.value as Lesson[];
        // this.lessonListThisMonth = data.value as LessonBooking[];
        // this.sliderInfoList = data.value as Info[];
        // this.gridInfoList = data.value as Info[];
        console.log('home data fetched:', data);
      } catch (err) {
        console.error('Error fetching lesson list:', err);
      }
    },
  },
});
