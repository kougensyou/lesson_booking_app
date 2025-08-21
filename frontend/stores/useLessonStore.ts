import { defineStore } from 'pinia';
import type {
  Lesson,
  LessonCategory,
  SearchInputForm,
  SearchInputData,
} from '~/types/lesson';

export const useLessonStore = defineStore('lesson', {
  state: () => ({
    nextLessonList: [] as Lesson[],
    sameStudioLessonList: [] as Lesson[],
    lessonCategoryList: [] as LessonCategory[],
    searchInputForm: {
      selectedDates: [] as string[],
    } as SearchInputForm,
    searchedLessonList: [] as Lesson[],
    startTimeOptions: [] as string[],
    endTimeOptions: [] as string[],
    selectedMonth: new Date().getMonth(),
    selectedYear: new Date().getFullYear(),
    todayMonth: new Date().getMonth() + 1,
    todayYear: new Date().getFullYear(),
    todayDay: new Date().getDate(),
  }),
  actions: {
    checkSelected(day: number): boolean {
      return this.searchInputForm.selectedDates.includes(
        this.selectedYear.toString() +
          '-' +
          (this.selectedMonth + 1).toString().padStart(2, '0') +
          '-' +
          day.toString().padStart(2, '0')
      );
    },
    changeByPrev() {
      this.selectedMonth -= 1;
      if (this.selectedMonth < 0) {
        this.selectedMonth = 11;
        this.selectedYear -= 1;
      }
    },
    changeByNext() {
      this.selectedMonth += 1;
      if (this.selectedMonth > 11) {
        this.selectedMonth = 0;
        this.selectedYear += 1;
      }
    },
    removeSelected(day: number) {
      this.searchInputForm.selectedDates =
        this.searchInputForm.selectedDates.filter(
          (date) =>
            date !==
            this.selectedYear.toString() +
              '-' +
              (this.selectedMonth + 1).toString().padStart(2, '0') +
              '-' +
              day.toString().padStart(2, '0')
        );
    },
    addSelected(day: number) {
      this.searchInputForm.selectedDates.push(
        this.selectedYear.toString() +
          '-' +
          (this.selectedMonth + 1).toString().padStart(2, '0') +
          '-' +
          day.toString().padStart(2, '0')
      );
    },
    async getNextLessonData() {
      try {
        const { data } = await useSanctumFetch('/api/get_next_lesson_data', {
          method: 'GET',
        });
        this.nextLessonList = data.value as Lesson[];
        console.log(' data fetched:', data.value);
      } catch (err) {
        console.error('Error fetching lesson list:', err);
      }
    },
    async getSameStudioLessonList(studioId: string) {
      try {
        const { data } = await useSanctumFetch(
          '/api/get_same_studio_lesson_list',
          {
            method: 'GET',
            query: {
              studio_id: studioId,
            },
          }
        );
        this.sameStudioLessonList = data.value as Lesson[];
        console.log('same studio lesson data fetched:', data.value);
      } catch (err) {
        console.error('Error fetching same studio lesson data:', err);
      }
    },
    async getSearchInputData() {
      try {
        const { data } = await useSanctumFetch('/api/get_search_input_data', {
          method: 'GET',
        });
        const searchInputData = data.value as SearchInputData;
        this.lessonCategoryList = searchInputData.lesson_category_list;
        this.startTimeOptions = searchInputData.start_time_options;
        this.endTimeOptions = searchInputData.end_time_options;
        this.searchInputForm.selectedDates[0] =
          this.todayYear.toString() +
          '-' +
          this.todayMonth.toString().padStart(2, '0') +
          '-' +
          this.todayDay.toString().padStart(2, '0');
      } catch (err) {
        console.error('Error getSearchInputData:', err);
      }
    },
    async searchLessonsApi() {
      try {
        console.log('searching lessons with input:', this.searchInputForm);
        const { data } = await useSanctumFetch('/api/search_lessons', {
          method: 'POST',
          body: { searchInputForm: this.searchInputForm },
        });
        this.searchedLessonList = data.value as Lesson[];
        console.log('searched lessons:', this.searchedLessonList);
      } catch (err) {
        console.error('Error searching lessons:', err);
      }
    },
  },
});
