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
    // Loading
    isSelectedLessonLoading: false as boolean,
    isBookingStatusLoading: false as boolean,
    isBookingHistoryLoading: false as boolean,
    isFirstBookingLoading: false as boolean,
    // Lesson List
    selectedLessonList: [] as LessonBooking[],
    bookingHistoryList: [] as Lesson[],
    // Calendar Settings
    calendarLocale: '' as string,
    calendarThemeColor: 'blue',
    selectedMonth: new Date().getMonth(),
    selectedYear: new Date().getFullYear(),
    todayMonth: new Date().getMonth() + 1,
    todayYear: new Date().getFullYear(),
    todayDay: new Date().getDate(),
    // Dialog
    isDialogOpen: false as boolean,
    // Pagination
    loadedPage: 0 as number,
    lastPage: 0 as number,
    // First Lesson Booking
    firstBooking: {
      selected_lesson: {
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
    // Errors
    errors: {} as any,
  }),
  persist: {
    storage: sessionStorage,
    pick: ['firstBooking'],
  },
  getters: {
    attributes(state): Array<Attribute> {
      return (state.selectedLessonList ?? []).map((lesson, idx) => ({
        key: idx,
        dates: [(this as any).parseDateString(lesson.start_time)],
        customData: {
          done_flag: lesson.done_flag,
        },
      }));
    },
  },
  actions: {
    initializeFirstBooking() {
      this.firstBooking = {
        selected_lesson: {
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
      };
    },
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
    // Parse a date string into a Date object.
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
        // console.log('getSelectedLessonList:', data.value);
      } catch (err: any) {
        this.isSelectedLessonLoading = false;
        console.error('Error getSelectedLessonList:', err.data);
        throw err;
      }
    },
    // Get booked lessons for previous month
    async getPrevLessonList() {
      // console.log('getPrevLessonList called');
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
        // console.log('getPrevLessonList:', selectedLessonList);
      } catch (err: any) {
        console.error('Error getPrevLessonList:', err.data);
        throw err;
      }
    },
    // Get booked lessons for next month
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
        // console.log('getNextLessonList:', selectedLessonList);
      } catch (err: any) {
        console.error('Error getNextLessonList:', err.data);
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
        // console.log('bookLessonApi:', data.value);
      } catch (err: any) {
        this.closeDialog();
        this.isBookingStatusLoading = false;
        console.error('Error bookLessonApi:', err.data);
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
        // console.log('cancelLessonApi:', data.value);
      } catch (err: any) {
        this.closeDialog();
        this.isBookingStatusLoading = false;
        console.error('Error cancelLessonApi:', err.data);
        throw err;
      }
    },
    initializeBookingHistory() {
      this.loadedPage = 0;
      this.lastPage = 0;
      this.isBookingHistoryLoading = false;
      this.bookingHistoryList = [];
    },
    // Load more booking history
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
        // console.log('addBookingHistory:', bookingHistoryResponse);
      } catch (err: any) {
        this.isBookingHistoryLoading = false;
        console.error('Error addBookingHistory:', err.data);
        throw err;
      }
    },
    // Set first selected lesson
    setFirstSelectedLesson(studioLessonData: BaseStudioLesson) {
      this.firstBooking.selected_lesson.lesson_day =
        studioLessonData.lesson_day;
      this.firstBooking.selected_lesson.lesson_time =
        studioLessonData.lesson_time;
      this.firstBooking.selected_lesson.lesson_name =
        studioLessonData.lesson_name;
    },
    initializeFirstSelectedLesson() {
      this.firstBooking.selected_lesson.lesson_day = '';
      this.firstBooking.selected_lesson.lesson_time = '';
      this.firstBooking.selected_lesson.lesson_name = '';
    },
    // Validate first lesson booking
    async validateFirstLessonApi() {
      this.isFirstBookingLoading = true;
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
        // console.log('validateFirstLessonApi:', data.value);
        this.isFirstBookingLoading = false;
        this.initializeErrors();
      } catch (err: any) {
        console.error('Error validateFirstLessonApi:', err.data);
        this.isFirstBookingLoading = false;
        if (err.statusCode === 422) {
          this.setErrors(err.data.errors);
        }
        throw err;
      }
    },
    async applyFirstLessonApi() {
      this.isFirstBookingLoading = true;
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
        this.isFirstBookingLoading = false;
        // console.log('applyFirstLessonApi:', data.value);
      } catch (err: any) {
        this.closeDialog();
        this.isFirstBookingLoading = false;
        console.error('Error applyFirstLessonApi:', err.data);
        throw err;
      }
    },
  },
});
