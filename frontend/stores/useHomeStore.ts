import { defineStore } from 'pinia';
import type { Lesson, Info, LessonBooking, HomeData } from '~/types/home';

export const useHomeStore = defineStore('home', {
  state: () => ({
    nextLessonList: [] as Lesson[],
    lessonListThisMonth: [] as LessonBooking[],
    sliderInfoList: [] as Info[],
    gridInfoList: [] as Info[],
  }),
  actions: {
    async getHomeData() {
      try {
        const { data } = await useSanctumFetch('/api/get_home_data');
        const homeData = data.value as HomeData;
        this.nextLessonList = homeData.next_lesson_list as Lesson[];
        this.lessonListThisMonth =
          homeData.lesson_list_this_month as LessonBooking[];
        this.sliderInfoList = homeData.info_list.slider_info as Info[];
        this.gridInfoList = homeData.info_list.grid_info as Info[];
        console.log('home data fetched:', homeData);
      } catch (err) {
        console.error('Error fetching lesson list:', err);
      }
    },
  },
});
