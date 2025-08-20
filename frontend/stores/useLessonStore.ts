import { defineStore } from 'pinia';
import type { BookDoneData } from '~/types/bookDone';
import type { Lesson } from '~/types/lesson';
import type { LessonCategory, SearchInputForm } from '~/types/lessonBooking';

export const useLessonStore = defineStore('lesson', {
  state: () => ({
    nextLessonList: [] as Lesson[],
    sameStudioLessonList: [] as Lesson[],
    lessonCategoryList: [] as LessonCategory[],
    searchInputForm: {
      selectedDates: [] as string[],
    } as SearchInputForm,
    searchedLessonList: [] as Lesson[],
  }),
  actions: {
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
    async getBookDoneData(studioId: string) {
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
        const bookDoneData = data.value as BookDoneData;
        this.sameStudioLessonList =
          bookDoneData.same_studio_lesson_list as Lesson[];
        console.log('book done data fetched:', bookDoneData);
      } catch (err) {
        console.error('Error fetching book done data:', err);
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
