import { start } from '@popperjs/core';
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
    searchInputForm: {} as SearchInputForm,
    searchedLessonList: [] as Lesson[],
    startTimeOptions: [] as string[],
    endTimeOptions: [] as string[],
  }),
  actions: {
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
