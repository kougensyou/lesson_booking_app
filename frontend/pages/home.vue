<script setup lang="ts">
import { useLessonStore } from '../stores/useLessonStore';
import { useLessonCalendarStore } from '~/stores/useLessonCalendarStore';
import { useInformationStore } from '~/stores/useInformationStore';
import NextLesson from '~/components/home/nextLesson.vue';
import LessonCalendar from '~/components/home/lessonCalendar.vue';
import Information from '~/components/home/information.vue';

const lessonStore = useLessonStore();
const lessonCalendarStore = useLessonCalendarStore();
const informationStore = useInformationStore();

await lessonStore.getNextLessonData();
await lessonCalendarStore.getSelectedLessonList();
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
    :selected-lesson-list="lessonCalendarStore.selectedLessonList"
    :attributes="lessonCalendarStore.attributes"
    :calendar-theme-color="lessonCalendarStore.calendarThemeColor"
    :check-today="lessonCalendarStore.checkToday"
    :get-prev-lesson-list="lessonCalendarStore.getPrevLessonList"
    :get-next-lesson-list="lessonCalendarStore.getNextLessonList"
  />
  <Information
    :slider-info-list="informationStore.sliderInfoList"
    :grid-info-list="informationStore.gridInfoList"
    :list-info-list="informationStore.listInfoList"
  />
</template>
