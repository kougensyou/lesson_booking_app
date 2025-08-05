import { defineStore } from 'pinia';
import type {
  Lesson,
  Info,
  LessonBooking,
  HomeData,
  Attribute,
} from '~/types/home';

export const useHomeStore = defineStore('home', {
  state: () => ({
    nextLessonList: [] as Lesson[],
    selectedLessonList: [] as LessonBooking[],
    sliderInfoList: [] as Info[],
    gridInfoList: [] as Info[],
    calendarThemeColor: 'green',
    selectedMonth: new Date().getMonth(),
    selectedYear: new Date().getFullYear(),
    todayMonth: new Date().getMonth() + 1,
    todayYear: new Date().getFullYear(),
    todayDay: new Date().getDate(),
  }),
  getters: {
    attributes(state): Array<Attribute> {
      return (state.selectedLessonList ?? []).map((lesson, idx) => ({
        key: idx,
        dates: (this as any).parseDateString(lesson.start_time),
        customData: {
          done_flag: lesson.done_flag,
        },
      }));
    },
  },
  actions: {
    parseDateString(dateStr: string | undefined | null): Date {
      if (!dateStr || typeof dateStr !== 'string') return new Date('');
      return new Date(dateStr.replace(' ', 'T'));
    },
    checkToday(day: number): boolean {
      return (
        this.todayYear === this.selectedYear &&
        this.todayMonth === this.selectedMonth + 1 &&
        this.todayDay === day
      );
    },
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
          this.selectedMonth = 0;
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
