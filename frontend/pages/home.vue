<script setup lang="ts">
import { useLessonStore } from '../stores/useLessonStore';
import { useLessonBookingStore } from '~/stores/useLessonBookingStore';
import { useInformationStore } from '~/stores/useInformationStore';
import { useApiErrorHandler } from '~/composables/useApiErrorHandler';
import { useRouter } from 'vue-router';
import NextLesson from '~/components/home/NextLesson.vue';
import LessonCalendar from '~/components/home/LessonCalendar.vue';
import Information from '~/components/home/Information.vue';
import SpinLoading from '~/components/common/SpinLoading.vue';
import RectLoading from '~/components/common/RectLoading.vue';

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
    v-if="lessonStore.isNextLessonLoading"
    class="flex items-center justify-center pt-12 pb-12"
  >
    <SpinLoading />
  </div>
  <NextLesson
    v-if="!lessonStore.isNextLessonLoading"
    :next-lesson-list="lessonStore.nextLessonList"
  />

  <div v-if="lessonBookingStore.isSelectedLessonLoading">
    <RectLoading cardHeight="h-96" cardWidth="w-full" />
  </div>
  <LessonCalendar
    v-if="!lessonBookingStore.isSelectedLessonLoading"
    :calendar-locale="lessonBookingStore.calendarLocale"
    :selected-lesson-list="lessonBookingStore.selectedLessonList"
    :attributes="lessonBookingStore.attributes"
    :calendar-theme-color="lessonBookingStore.calendarThemeColor"
    :check-today="lessonBookingStore.checkToday"
    :get-prev-lesson-list="lessonBookingStore.getPrevLessonList"
    :get-next-lesson-list="lessonBookingStore.getNextLessonList"
  />

  <div
    v-if="informationStore.isInformationLoading"
    class="flex items-center justify-center pt-12 pb-12"
  >
    <SpinLoading />
  </div>
  <Information
    v-if="!informationStore.isInformationLoading"
    :slider-info-list="informationStore.sliderInfoList"
    :grid-info-list="informationStore.gridInfoList"
    :list-info-list="informationStore.listInfoList"
  />
</template>
