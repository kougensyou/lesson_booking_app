<script setup lang="ts">
import { useLessonStore } from '../stores/useLessonStore';
import { useLessonBookingStore } from '~/stores/useLessonBookingStore';
import { useInformationStore } from '~/stores/useInformationStore';
import { useApiErrorHandler } from '~/composables/useApiErrorHandler';
import { useRouter } from 'vue-router';
import NextLesson from '~/components/home/NextLesson.vue';
import LessonCalendar from '~/components/home/LessonCalendar.vue';
import Information from '~/components/home/Information.vue';

definePageMeta({
  layout: 'bg-gradation',
  middleware: 'auth',
});

const router = useRouter();

const lessonStore = useLessonStore();
const lessonBookingStore = useLessonBookingStore();
const informationStore = useInformationStore();

lessonBookingStore.setCalendarLocaleForHome();

lessonStore.getNextLessonData().catch((error: any) => {
  useApiErrorHandler(router, error);
});
lessonBookingStore.getSelectedLessonList().catch((error: any) => {
  useApiErrorHandler(router, error);
});
informationStore.getInformationList().catch((error: any) => {
  useApiErrorHandler(router, error);
});
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('home.tabTitle') }}</title>
    </Head>
  </div>

  <div
    v-if="
      lessonStore.isNextLessonLoading ||
      lessonBookingStore.isSelectedLessonLoading ||
      informationStore.isInformationLoading
    "
    class="fixed inset-0 bg-opacity-50 z-50"
  ></div>

  <NextLesson
    :is-next-lesson-loading="lessonStore.isNextLessonLoading"
    :next-lesson-list="lessonStore.nextLessonList"
  />

  <LessonCalendar
    :is-selected-lesson-loading="lessonBookingStore.isSelectedLessonLoading"
    :calendar-locale="lessonBookingStore.calendarLocale"
    :selected-lesson-list="lessonBookingStore.selectedLessonList"
    :attributes="lessonBookingStore.attributes"
    :calendar-theme-color="lessonBookingStore.calendarThemeColor"
    :check-today="lessonBookingStore.checkToday"
    :get-prev-lesson-list="lessonBookingStore.getPrevLessonList"
    :get-next-lesson-list="lessonBookingStore.getNextLessonList"
  />

  <Information
    :is-information-loading="informationStore.isInformationLoading"
    :slider-info-list="informationStore.sliderInfoList"
    :grid-info-list="informationStore.gridInfoList"
    :list-info-list="informationStore.listInfoList"
  />
</template>
