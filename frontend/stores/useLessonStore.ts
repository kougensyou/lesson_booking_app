import { defineStore } from 'pinia';
import type {
  Lesson,
  LessonCategory,
  SearchInputForm,
  TimeOptions,
  LessonDetail,
  Studio,
  WeekData,
  StudioLesson,
  StudioLessonData,
} from '~/types/lesson';

export const useLessonStore = defineStore('lesson', {
  state: () => ({
    isNextLessonLoading: false as boolean,
    nextLessonList: [] as Lesson[],
    sameStudioLessonList: [] as Lesson[],
    isLessonCategoryLoading: false as boolean,
    lessonCategoryList: [] as LessonCategory[],
    searchInputForm: {
      selectedDates: [] as string[],
    } as SearchInputForm,
    loadedPage: 0 as number,
    lastPage: 0 as number,
    isAddLessonLoading: false as boolean,
    searchedLessonList: [] as Lesson[],
    startTimeOptions: [] as string[],
    endTimeOptions: [] as string[],
    selectedMonth: new Date().getMonth(),
    selectedYear: new Date().getFullYear(),
    todayMonth: new Date().getMonth() + 1,
    todayYear: new Date().getFullYear(),
    todayDay: new Date().getDate(),
    lessonId: '',
    isLessonDetailLoading: false as boolean,
    lessonDetail: {} as LessonDetail,
    studioData: {} as Studio,
    weekData: [] as WeekData[],
    isTimeOptionsLoading: false as boolean,
    timeOptions: [] as string[],
    fromDate: '',
    toDate: '',
    isStudioLessonLoading: false as boolean,
    studioLessonList: {} as StudioLesson,
    selectedStudioId: '',
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
      this.isNextLessonLoading = true;
      try {
        const { data, error } = await useSanctumFetch(
          '/api/get_next_lesson_data',
          {
            method: 'GET',
          }
        );
        if (error.value) {
          throw createError({
            statusCode: error.value.statusCode,
            message: error.value.message,
          });
        }
        this.nextLessonList = data.value as Lesson[];
        this.isNextLessonLoading = false;
        console.log(' data fetched:', data.value);
      } catch (err: any) {
        this.isNextLessonLoading = false;
        console.error('Error fetching lesson list:', err);
        throw err;
      }
    },
    initializePaginationData() {
      this.loadedPage = 0;
      this.lastPage = 0;
      this.isAddLessonLoading = false;
      this.searchedLessonList = [] as Lesson[];
      this.sameStudioLessonList = [] as Lesson[];
    },
    async addSameStudioLessonList(studioId: string) {
      this.isAddLessonLoading = true;
      try {
        const { data, error } = await useSanctumFetch(
          '/api/add_same_studio_lesson_list',
          {
            method: 'GET',
            query: {
              page: ++this.loadedPage,
              studio_id: studioId,
            },
          }
        );
        if (error.value) {
          throw createError({
            statusCode: error.value.statusCode,
            message: error.value.message,
          });
        }
        const sameStudioLessonsResponse = data.value as any;
        this.sameStudioLessonList = this.sameStudioLessonList.concat(
          sameStudioLessonsResponse.data
        );
        this.lastPage = sameStudioLessonsResponse.last_page;
        this.isAddLessonLoading = false;
        console.log('same studio lesson data fetched:', data.value);
      } catch (err) {
        this.isAddLessonLoading = false;
        console.error('Error fetching same studio lesson data:', err);
        throw err;
      }
    },
    async getLessonCategoryList() {
      this.isLessonCategoryLoading = true;
      try {
        const { data, error } = await useSanctumFetch(
          '/api/get_lesson_category_list',
          {
            method: 'GET',
          }
        );
        if (error.value) {
          throw createError({
            statusCode: error.value.statusCode,
            message: error.value.message,
          });
        }
        this.lessonCategoryList = data.value as LessonCategory[];
        this.isLessonCategoryLoading = false;
      } catch (err) {
        this.isLessonCategoryLoading = false;
        console.error('Error getLessonCategoryList:', err);
        throw err;
      }
    },
    async getTimeOptions() {
      this.isTimeOptionsLoading = true;
      try {
        const { data, error } = await useSanctumFetch('/api/get_time_options', {
          method: 'GET',
        });
        if (error.value) {
          throw createError({
            statusCode: error.value.statusCode,
            message: error.value.message,
          });
        }
        const timeOptionsData = data.value as TimeOptions;
        this.startTimeOptions = timeOptionsData.start_time_options;
        this.endTimeOptions = timeOptionsData.end_time_options;
        this.isTimeOptionsLoading = false;
      } catch (err) {
        this.isTimeOptionsLoading = false;
        console.error('Error getTimeOptions:', err);
        throw err;
      }
    },
    async initializeSelectedDates() {
      this.searchInputForm.selectedDates[0] =
        this.todayYear.toString() +
        '-' +
        this.todayMonth.toString().padStart(2, '0') +
        '-' +
        this.todayDay.toString().padStart(2, '0');
    },
    async addSearchedLessonsApi() {
      this.isAddLessonLoading = true;
      try {
        const { data, error } = await useSanctumFetch(
          '/api/add_searched_lessons',
          {
            method: 'GET',
            query: {
              page: ++this.loadedPage,
              search_input_form: this.searchInputForm,
            },
          }
        );
        if (error.value) {
          throw createError({
            statusCode: error.value.statusCode,
            message: error.value.message,
          });
        }
        const searchedLessonsResponse = data.value as any;
        this.searchedLessonList = this.searchedLessonList.concat(
          searchedLessonsResponse.data
        );
        this.lastPage = searchedLessonsResponse.last_page;
        this.isAddLessonLoading = false;
        console.log('searched lessons:', this.searchedLessonList);
      } catch (err) {
        this.isAddLessonLoading = false;
        console.error('Error searching lessons:', err);
        throw err;
      }
    },
    setLessonId(lessonId: string) {
      this.lessonId = lessonId;
    },
    async getLessonDetailApi() {
      this.isLessonDetailLoading = true;
      try {
        const { data, error } = await useSanctumFetch(
          '/api/get_lesson_detail',
          {
            method: 'GET',
            query: {
              lesson_id: this.lessonId,
            },
          }
        );
        if (error.value) {
          throw createError({
            statusCode: error.value.statusCode,
            message: error.value.message,
          });
        }
        this.lessonDetail = data.value as LessonDetail;
        this.isLessonDetailLoading = false;
        console.log('lesson detail data fetched:', this.lessonDetail);
      } catch (err) {
        this.isLessonDetailLoading = false;
        console.error('Error fetching lesson detail data:', err);
        throw err;
      }
    },
    setStudioId(studioId: string) {
      this.selectedStudioId = studioId;
    },
    setDate(baseDate: Date) {
      this.fromDate = baseDate.toLocaleDateString('sv-SE');
      this.toDate = new Date(
        baseDate.getTime() + 6 * 24 * 60 * 60 * 1000
      ).toLocaleDateString('sv-SE');
    },
    setWeekData() {
      this.weekData = [];
      const date = new Date(this.fromDate);
      for (let i = 0; i < 7; i++) {
        const day = new Date(date.getTime() + i * 24 * 60 * 60 * 1000);
        this.weekData.push({
          dateObj: day,
          date: `${day.getMonth() + 1}/${day.getDate()}`,
          day: day.getDate(),
          label: ['日', '月', '火', '水', '木', '金', '土'][day.getDay()],
          active: i === 0,
        });
      }
    },
    async getStudioLessonDataApi() {
      this.isStudioLessonLoading = true;
      try {
        const { data, error } = await useSanctumFetch(
          '/api/get_studio_lesson_data',
          {
            method: 'GET',
            query: {
              studio_id: this.selectedStudioId,
              from_date: this.fromDate,
              to_date: this.toDate,
            },
          }
        );
        if (error.value) {
          throw createError({
            statusCode: error.value.statusCode,
            message: error.value.message,
          });
        }
        const studioLessonData = data.value as StudioLessonData;
        this.timeOptions = studioLessonData.time_options;
        this.studioData = studioLessonData.studio_data as Studio;
        this.studioLessonList = studioLessonData.studio_lesson_list;
        this.isStudioLessonLoading = false;
        console.log('studio lesson data fetched:', studioLessonData);
      } catch (err) {
        this.isStudioLessonLoading = false;
        console.error('Error fetching studio lesson data:', err);
        throw err;
      }
    },
  },
});
