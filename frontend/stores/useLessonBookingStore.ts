import { defineStore } from 'pinia';
import type {
  FavoriteStudio,
  LessonBookingData,
  Studio,
  LessonCategory,
  Lesson,
  SearchInputForm,
} from '~/types/lessonBooking';

export const useLessonBookingStore = defineStore('lessonBooking', {
  state: () => ({
    favoriteStudioList: [] as FavoriteStudio[],
    studioList: [] as Studio[],
    lessonCategoryList: [] as LessonCategory[],
    calendarThemeColor: 'green',
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
          (this.selectedMonth + 1).toString() +
          '-' +
          day.toString()
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
              (this.selectedMonth + 1).toString() +
              '-' +
              day.toString()
        );
    },
    addSelected(day: number) {
      this.searchInputForm.selectedDates.push(
        this.selectedYear.toString() +
          '-' +
          (this.selectedMonth + 1).toString() +
          '-' +
          day.toString()
      );
    },
    async getLessonBookingData() {
      try {
        const { data } = await useSanctumFetch('/api/get_lesson_booking_data', {
          method: 'GET',
        });
        const lessonBookingData = data.value as LessonBookingData;
        this.favoriteStudioList = lessonBookingData.favorite_studio_list;
        this.studioList = lessonBookingData.studio_list;
        this.lessonCategoryList = lessonBookingData.lesson_category_list;
        this.startTimeOptions = lessonBookingData.start_time_options;
        this.endTimeOptions = lessonBookingData.end_time_options;
        this.searchInputForm.selectedDates[0] =
          this.todayYear.toString() +
          '-' +
          this.todayMonth.toString() +
          '-' +
          this.todayDay.toString();
        console.log('lesson booking data fetched:', lessonBookingData);
      } catch (err) {
        console.error('Error fetching lesson booking data:', err);
      }
    },
    async searchLessons() {
      try {
        console.log('searching lessons with input:', this.searchInputForm);
        // const { data } = await useSanctumFetch('/api/search_lessons', {
        //   method: 'GET',
        //   query: { searchInputForm: this.searchInputForm },
        // });
        // this.searchedLessonList = data.value as Lesson[];
        // console.log('searched lessons:', this.searchedLessonList);
      } catch (err) {
        console.error('Error searching lessons:', err);
      }
    },
  },
});
