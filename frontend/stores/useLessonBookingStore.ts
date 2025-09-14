import { defineStore } from 'pinia';
import type {
  LessonBooking,
  Attribute,
  FirstBooking,
  FirstSelectedLesson,
  FirstUser,
} from '~/types/lessonBooking';
import type { BaseStudioLesson, Lesson } from '~/types/lesson';

export const useLessonBookingStore = defineStore('lessonBooking', {
  state: () => ({
    selectedLessonList: [] as LessonBooking[],
    calendarThemeColor: 'green',
    selectedMonth: new Date().getMonth(),
    selectedYear: new Date().getFullYear(),
    todayMonth: new Date().getMonth() + 1,
    todayYear: new Date().getFullYear(),
    todayDay: new Date().getDate(),
    isDialogOpen: false as boolean,
    loadedPage: 0 as number,
    lastPage: 0 as number,
    isLoading: false as boolean,
    bookingHistoryList: [] as Lesson[],
    firstBooking: {
      selectedLesson: {
        lesson_category_name: '',
        studio_name: '',
        lesson_day: '',
        lesson_time: '',
        lesson_name: '',
      } as FirstSelectedLesson,
      user: {
        name: '',
        email: '',
        birth_date: '',
      } as FirstUser,
    } as FirstBooking,
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
    async getSelectedLessonList() {
      try {
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
        this.selectedLessonList = data.value as LessonBooking[];
        console.log('home data fetched:', data.value);
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
    openDialog() {
      this.isDialogOpen = true;
    },
    closeDialog() {
      this.isDialogOpen = false;
    },
    async bookLessonApi(lessonId: string) {
      try {
        const { data } = await useSanctumFetch('/api/book_lesson', {
          method: 'POST',
          body: {
            lesson_id: lessonId,
          },
        });
        this.closeDialog();
        console.log('bookLesson fetched:', data.value);
      } catch (err) {
        console.error('Error fetching bookLesson data:', err);
      }
    },
    async cancelLessonApi(lessonId: string) {
      try {
        const { data } = await useSanctumFetch('/api/cancel_lesson', {
          method: 'POST',
          body: {
            lesson_id: lessonId,
          },
        });
        this.closeDialog();
        console.log('cancelLesson fetched:', data.value);
      } catch (err) {
        console.error('Error fetching cancelLesson data:', err);
      }
    },
    changeIsLoading() {
      this.isLoading = true;
    },
    initializeBookingHistory() {
      this.loadedPage = 0;
      this.lastPage = 0;
      this.isLoading = false;
      this.bookingHistoryList = [];
    },
    async addBookingHistory() {
      try {
        const { data } = await useSanctumFetch('/api/add_booking_history', {
          method: 'GET',
          query: {
            page: ++this.loadedPage,
          },
        });
        const bookingHistoryResponse = data.value as any;
        this.bookingHistoryList = this.bookingHistoryList.concat(
          bookingHistoryResponse.data
        );
        this.lastPage = bookingHistoryResponse.last_page;
        this.isLoading = false;
        console.log('booking history fetched:', bookingHistoryResponse);
      } catch (err) {
        console.error('Error fetching booking history:', err);
      }
    },
    setFirstSelectedLesson(studioLessonData: BaseStudioLesson) {
      this.firstBooking.selectedLesson.lesson_day = studioLessonData.lesson_day;
      this.firstBooking.selectedLesson.lesson_time =
        studioLessonData.lesson_time;
      this.firstBooking.selectedLesson.lesson_name =
        studioLessonData.lesson_name;
    },
    initializeFirstSelectedLesson() {
      this.firstBooking.selectedLesson.lesson_day = '';
      this.firstBooking.selectedLesson.lesson_time = '';
      this.firstBooking.selectedLesson.lesson_name = '';
    },
    async applyFirstLessonApi() {
      try {
        const { data } = await useSanctumFetch('/api/apply_first_lesson', {
          method: 'POST',
          body: {
            first_booking: this.firstBooking,
          },
        });
        this.closeDialog();
        console.log('applyFirstLesson fetched:', data.value);
      } catch (err) {
        console.error('Error fetching applyFirstLesson data:', err);
      }
    },
  },
});
