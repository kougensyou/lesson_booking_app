<script setup lang="ts">
import { useLessonStore } from '../stores/useLessonStore';
import { useLessonBookingStore } from '~/stores/useLessonBookingStore';
import { useInformationStore } from '~/stores/useInformationStore';
import NextLesson from '~/components/home/NextLesson.vue';
import LessonCalendar from '~/components/home/LessonCalendar.vue';
import Information from '~/components/home/Information.vue';

const lessonStore = useLessonStore();
const lessonBookingStore = useLessonBookingStore();
const informationStore = useInformationStore();

await lessonStore.getNextLessonData();
await lessonBookingStore.getSelectedLessonList();
await informationStore.getInformationList();
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('home.tabTitle') }}</title>
    </Head>
  </div>
  <NextLesson :next-lesson-list="lessonStore.nextLessonList" />
  <LessonCalendar
    :selected-lesson-list="lessonBookingStore.selectedLessonList"
    :attributes="lessonBookingStore.attributes"
    :calendar-theme-color="lessonBookingStore.calendarThemeColor"
    :check-today="lessonBookingStore.checkToday"
    :get-prev-lesson-list="lessonBookingStore.getPrevLessonList"
    :get-next-lesson-list="lessonBookingStore.getNextLessonList"
  />
  <Information
    :slider-info-list="informationStore.sliderInfoList"
    :grid-info-list="informationStore.gridInfoList"
    :list-info-list="informationStore.listInfoList"
  />
</template>
