<script lang="ts" setup>
import { useLessonStore } from '../stores/useLessonStore';
import { useUserStore } from '../stores/useUserStore';
import { useRoute } from 'vue-router';
import StudioLessonCalendar from '~/components/common/StudioLessonCalendar.vue';

const route = useRoute();

const lessonStore = useLessonStore();
const userStore = useUserStore();

const studioId = route.query.studio_id as string;

const changeStudioLessonData = (selectedDateObj: Date) => {
  lessonStore.setDate(selectedDateObj);
  lessonStore.setWeekData();
  lessonStore.getStudioLessonDataApi();
};

lessonStore.setStudioId(studioId);
lessonStore.setDate(new Date());
lessonStore.setWeekData();
await lessonStore.getStudioLessonDataApi();
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('lessonBooking.tabTitle') }}</title>
    </Head>
  </div>
  <div class="pb-4">
    <StudioLessonCalendar
      :is-auth="userStore.user.id ? true : false"
      :studio-name="lessonStore.studioData.studio_name"
      :week-data="lessonStore.weekData"
      :studio-lesson-list="lessonStore.studioLessonList"
      :time-options="lessonStore.timeOptions"
      :change-studio-lesson-data="changeStudioLessonData"
      :click-card="
        (studioLesson: any) => {
          $router.push({
            path: '/lessonDetail',
            query: { lesson_id: studioLesson.lesson_id },
          });
        }
      "
    />
  </div>
</template>
