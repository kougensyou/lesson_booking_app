import { defineStore } from 'pinia';
import type {
  StudioLesson,
  StudioLessonData,
  WeekData,
  Studio,
} from '~/types/studioLesson';

export const useStudioLessonStore = defineStore('studioLesson', {
  state: () => ({
    studioData: {} as Studio,
    weekData: [] as WeekData[],
    timeOptions: [] as string[],
    fromDate: '',
    toDate: '',
    studioLessonList: [] as StudioLesson[],
  }),
  actions: {
    checkSelected() {},
    setDate(baseDate: Date) {
      this.fromDate = baseDate.toISOString().split('T')[0];
      this.toDate = new Date(baseDate.getTime() + 6 * 24 * 60 * 60 * 1000)
        .toISOString()
        .split('T')[0];
    },
    setWeekData() {
      this.weekData = [];
      const date = new Date(this.fromDate);
      for (let i = 0; i < 7; i++) {
        const day = new Date(date.getTime() + i * 24 * 60 * 60 * 1000);
        this.weekData.push({
          date: `${day.getMonth() + 1}/${day.getDate()}`,
          day: day.getDate(),
          label: ['日', '月', '火', '水', '木', '金', '土'][day.getDay()],
          active: i === 0,
        });
      }
    },
    async getStudioLessonData(studioId: string) {
      this.setDate(new Date());
      try {
        const { data } = await useSanctumFetch('/api/get_studio_lesson_data', {
          method: 'GET',
          query: {
            studio_id: studioId,
            from_date: this.fromDate,
            to_date: this.toDate,
          },
        });
        const studioLessonData = data.value as StudioLessonData;
        this.timeOptions = studioLessonData.time_options;
        this.studioData = studioLessonData.studio_data as Studio;
        this.studioLessonList = studioLessonData.studio_lesson_list;
        console.log('studio lesson data fetched:', studioLessonData);
      } catch (err) {
        console.error('Error fetching studio lesson data:', err);
      }
    },
    async changeStudioLessonData(studioId: string) {
      try {
        const { data } = await useSanctumFetch('/api/get_studio_lesson_data', {
          method: 'GET',
          query: {
            studio_id: studioId,
            from_date: this.fromDate,
            to_date: this.toDate,
          },
        });
        const studioLessonData = data.value as StudioLessonData;
        this.timeOptions = studioLessonData.time_options;
        this.studioData = studioLessonData.studio_data as Studio;
        this.studioLessonList = studioLessonData.studio_lesson_list;
        console.log('studio lesson data fetched:', studioLessonData);
      } catch (err) {
        console.error('Error fetching studio lesson data:', err);
      }
    },
  },
});
