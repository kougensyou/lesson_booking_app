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
    isSelectedLessonLoading: false as boolean,
    selectedLessonList: [] as LessonBooking[],
    calendarLocale: '' as string,
    calendarThemeColor: 'blue',
    selectedMonth: new Date().getMonth(),
    selectedYear: new Date().getFullYear(),
    todayMonth: new Date().getMonth() + 1,
    todayYear: new Date().getFullYear(),
    todayDay: new Date().getDate(),
    isBookingStatusLoading: false as boolean,
    isDialogOpen: false as boolean,
    loadedPage: 0 as number,
    lastPage: 0 as number,
    isBookingHistoryLoading: false as boolean,
    bookingHistoryList: [] as Lesson[],
    firstBooking: {
      selectedLesson: {} as FirstSelectedLesson,
      user: {} as FirstUser,
    } as FirstBooking,
    errors: {} as any,
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
    initializeErrors() {
      this.errors = {};
    },
    setErrors(errors: any) {
      this.errors = errors;
    },
    setCalendarLocaleForHome() {
      const { t } = useI18n();
      this.calendarLocale = t('home.calendarLocale');
    },
    setCalendarLocaleForLessonBooking() {
      const { t } = useI18n();
      this.calendarLocale = t('lessonBooking.calendarLocale');
    },
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
      this.isSelectedLessonLoading = true;
      try {
        const { data, error } = await useSanctumFetch(
          '/api/get_selected_lesson_list',
          {
            method: 'GET',
            query: {
              selected_year: this.selectedYear,
              selected_month: this.selectedMonth,
            },
          }
        );
        if (error.value) {
          throw createError({
            statusCode: error.value.statusCode,
            message: error.value.message,
            data: error.value.data,
          });
        }
        this.selectedLessonList = data.value as LessonBooking[];
        this.isSelectedLessonLoading = false;
        console.log('home data fetched:', data.value);
      } catch (err: any) {
        this.isSelectedLessonLoading = false;
        console.error('Error fetching lesson list:', err);
        throw err;
      }
    },
    async getPrevLessonList() {
      console.log('getPrevLessonList called');
      try {
        this.selectedMonth -= 1;
        if (this.selectedMonth < 0) {
          this.selectedMonth = 11;
          this.selectedYear -= 1;
        }
        const { data, error } = await useSanctumFetch(
          '/api/get_selected_lesson_list',
          {
            method: 'GET',
            query: {
              selected_year: this.selectedYear,
              selected_month: this.selectedMonth,
            },
          }
        );
        if (error.value) {
          throw createError({
            statusCode: error.value.statusCode,
            message: error.value.message,
            data: error.value.data,
          });
        }
        const selectedLessonList = data.value as LessonBooking[];
        this.selectedLessonList = selectedLessonList;
        console.log('selected lesson list fetched:', selectedLessonList);
      } catch (err: any) {
        console.error('Error fetching lesson list:', err);
        throw err;
      }
    },
    async getNextLessonList() {
      try {
        this.selectedMonth += 1;
        if (this.selectedMonth > 11) {
          this.selectedMonth = 0;
          this.selectedYear += 1;
        }
        const { data, error } = await useSanctumFetch(
          '/api/get_selected_lesson_list',
          {
            method: 'GET',
            query: {
              selected_year: this.selectedYear,
              selected_month: this.selectedMonth,
            },
          }
        );
        if (error.value) {
          throw createError({
            statusCode: error.value.statusCode,
            message: error.value.message,
            data: error.value.data,
          });
        }
        const selectedLessonList = data.value as LessonBooking[];
        this.selectedLessonList = selectedLessonList;
        console.log('selected lesson list fetched:', selectedLessonList);
      } catch (err: any) {
        console.error('Error fetching lesson list:', err);
        throw err;
      }
    },
    openDialog() {
      this.isDialogOpen = true;
    },
    closeDialog() {
      this.isDialogOpen = false;
    },
    async bookLessonApi(lessonId: string) {
      this.isBookingStatusLoading = true;
      try {
        const { data, error } = await useSanctumFetch('/api/book_lesson', {
          method: 'POST',
          body: {
            lesson_id: lessonId,
          },
        });
        if (error.value) {
          throw createError({
            statusCode: error.value.statusCode,
            message: error.value.message,
            data: error.value.data,
          });
        }
        this.closeDialog();
        this.isBookingStatusLoading = false;
        console.log('bookLesson fetched:', data.value);
      } catch (err: any) {
        this.closeDialog();
        this.isBookingStatusLoading = false;
        console.error('Error fetching bookLesson data:', err);
        throw err;
      }
    },
    async cancelLessonApi(lessonId: string) {
      this.isBookingStatusLoading = true;
      try {
        const { data, error } = await useSanctumFetch('/api/cancel_lesson', {
          method: 'POST',
          body: {
            lesson_id: lessonId,
          },
        });
        if (error.value) {
          throw createError({
            statusCode: error.value.statusCode,
            message: error.value.message,
            data: error.value.data,
          });
        }
        this.closeDialog();
        this.isBookingStatusLoading = false;
        console.log('cancelLesson fetched:', data.value);
      } catch (err: any) {
        this.closeDialog();
        this.isBookingStatusLoading = false;
        console.error('Error fetching cancelLesson data:', err);
        throw err;
      }
    },
    initializeBookingHistory() {
      this.loadedPage = 0;
      this.lastPage = 0;
      this.isBookingHistoryLoading = false;
      this.bookingHistoryList = [];
    },
    async addBookingHistory() {
      this.isBookingHistoryLoading = true;
      try {
        const { data, error } = await useSanctumFetch(
          '/api/add_booking_history',
          {
            method: 'GET',
            query: {
              page: ++this.loadedPage,
            },
          }
        );
        if (error.value) {
          throw createError({
            statusCode: error.value.statusCode,
            message: error.value.message,
            data: error.value.data,
          });
        }
        const bookingHistoryResponse = data.value as any;
        this.bookingHistoryList = this.bookingHistoryList.concat(
          bookingHistoryResponse.data
        );
        this.lastPage = bookingHistoryResponse.last_page;
        this.isBookingHistoryLoading = false;
        console.log('booking history fetched:', bookingHistoryResponse);
      } catch (err: any) {
        this.isBookingHistoryLoading = false;
        console.error('Error fetching booking history:', err);
        throw err;
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
    async validateFirstLessonApi() {
      try {
        const { data, error } = await useSanctumFetch(
          '/api/validate_first_lesson',
          {
            method: 'POST',
            body: {
              first_booking: this.firstBooking,
            },
          }
        );
        if (error.value) {
          throw createError({
            statusCode: error.value.statusCode,
            message: error.value.message,
            data: error.value.data,
          });
        }
        console.log('validateFirstLesson fetched:', data.value);
      } catch (err: any) {
        console.error('Error fetching validateFirstLesson data:', err);
        if (err.statusCode === 422) {
          this.setErrors(err.data.errors);
          return;
        }
        throw err;
      }
    },
    async applyFirstLessonApi() {
      try {
        const { data, error } = await useSanctumFetch(
          '/api/apply_first_lesson',
          {
            method: 'POST',
            body: {
              first_booking: this.firstBooking,
            },
          }
        );
        if (error.value) {
          throw createError({
            statusCode: error.value.statusCode,
            message: error.value.message,
            data: error.value.data,
          });
        }
        this.closeDialog();
        console.log('applyFirstLesson fetched:', data.value);
      } catch (err: any) {
        this.closeDialog();
        console.error('Error fetching applyFirstLesson data:', err);
        throw err;
      }
    },
  },
});
