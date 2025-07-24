import { defineStore } from 'pinia';
import type { Lesson, Info, LessonBooking, HomeData } from '~/types/home';

export const useHomeStore = defineStore('home', {
  state: () => ({
    nextLessonList: [] as Lesson[],
    selectedLessonList: [] as LessonBooking[],
    sliderInfoList: [] as Info[],
    gridInfoList: [] as Info[],
    calendarThemeColor: 'green',
    selectedMonth: new Date().getMonth(),
    selectedYear: new Date().getFullYear(),
  }),
  actions: {
    async getHomeData() {
      try {
        const { data } = await useSanctumFetch('/api/get_home_data', {
          method: 'GET',
          query: {
            selected_year: this.selectedYear,
            selected_month: this.selectedMonth,
          },
        });
        const homeData = data.value as HomeData;
        this.nextLessonList = homeData.next_lesson_list as Lesson[];
        this.selectedLessonList =
          homeData.selected_lesson_list as LessonBooking[];
        this.sliderInfoList = homeData.info_list.slider_info as Info[];
        this.gridInfoList = homeData.info_list.grid_info as Info[];
        console.log('home data fetched:', homeData);
      } catch (err) {
        console.error('Error fetching lesson list:', err);
      }
    },
    async getPrevLessonList() {
      try {
        this.selectedMonth -= 1;
        if (this.selectedMonth < 0) {
          this.selectedMonth = 11;
          this.selectedYear -= 1;
        }
        const { data } = await useSanctumFetch(
          '/api/get_selected_lesson_list',
          {
            method: 'GET',
            query: {
              selected_year: this.selectedYear,
              selected_month: this.selectedMonth,
            },
          }
        );
        const selectedLessonList = data.value as LessonBooking[];
        this.selectedLessonList = selectedLessonList;
        console.log('selected lesson list fetched:', selectedLessonList);
      } catch (err) {
        console.error('Error fetching lesson list:', err);
      }
    },
    async getNextLessonList() {
      try {
        this.selectedMonth += 1;
        if (this.selectedMonth > 11) {
          this.selectedMonth = 9;
          this.selectedYear += 1;
        }
        const { data } = await useSanctumFetch(
          '/api/get_selected_lesson_list',
          {
            method: 'GET',
            query: {
              selected_year: this.selectedYear,
              selected_month: this.selectedMonth,
            },
          }
        );
        const selectedLessonList = data.value as LessonBooking[];
        this.selectedLessonList = selectedLessonList;
        console.log('selected lesson list fetched:', selectedLessonList);
      } catch (err) {
        console.error('Error fetching lesson list:', err);
      }
    },
  },
});
