<script lang="ts" setup>
import type { BaseStudioLesson } from '~/types/lesson';
import { useLessonStore } from '../stores/useLessonStore';
import { useUserStore } from '../stores/useUserStore';
import { useRoute, useRouter } from 'vue-router';
import { useApiErrorHandler } from '~/composables/useApiErrorHandler';
import StudioLessonCalendar from '~/components/common/StudioLessonCalendar.vue';
import SpinLoading from '~/components/common/SpinLoading.vue';

definePageMeta({
  middleware: 'auth',
});

const route = useRoute();
const router = useRouter();

const lessonStore = useLessonStore();
const userStore = useUserStore();

const studioId = route.query.studio_id as string;

const changeStudioLessonData = (selectedDateObj: Date) => {
  lessonStore.setDate(selectedDateObj);
  lessonStore.setWeekData();
  lessonStore.getStudioLessonDataApi().catch((error: any) => {
    useApiErrorHandler(router, error);
  });
};

lessonStore.setStudioId(studioId);
lessonStore.setDate(new Date());
lessonStore.setWeekData();
lessonStore.getStudioLessonDataApi().catch((error: any) => {
  useApiErrorHandler(router, error);
});
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('studioLesson.tabTitle') }}</title>
    </Head>
  </div>

  <div
    v-if="lessonStore.isStudioLessonLoading"
    class="fixed inset-0 bg-opacity-50 z-50"
  ></div>

  <div
    v-if="lessonStore.isStudioLessonLoading"
    class="fixed inset-0 flex items-center justify-center"
  >
    <SpinLoading />
  </div>
  <div class="pb-4">
    <StudioLessonCalendar
      :is-loading="lessonStore.isStudioLessonLoading"
      :vacant-message="$t('studioLesson.vacantMessage')"
      :no-vacant-message="$t('studioLesson.noVacantMessage')"
      :is-auth="userStore.user.id ? true : false"
      :studio-name="lessonStore.studioData.studio_name"
      :week-data="lessonStore.weekData"
      :studio-lesson-list="lessonStore.studioLessonList"
      :time-options="lessonStore.timeOptions"
      :change-studio-lesson-data="changeStudioLessonData"
      :click-card="
        (studioLesson: BaseStudioLesson) => {
          $router.push({
            path: '/lessonDetail',
            query: { lesson_id: studioLesson.lesson_id },
          });
        }
      "
    />
  </div>
</template>
