<script setup lang="ts">
import { useHomeStore } from '../stores/useHomeStore';
import NextLesson from '~/components/home/nextLesson.vue';
import LessonCalendar from '~/components/home/lessonCalendar.vue';
import Information from '~/components/home/information.vue';

const homeStore = useHomeStore();

await homeStore.getHomeData();
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('home.tabTitle') }}</title>
    </Head>
  </div>
  <NextLesson :next-lesson-list="homeStore.nextLessonList" />
  <LessonCalendar
    :selected-lesson-list="homeStore.selectedLessonList"
    :attributes="homeStore.attributes"
    :calendar-theme-color="homeStore.calendarThemeColor"
    :check-today="homeStore.checkToday"
    :get-prev-lesson-list="homeStore.getPrevLessonList"
    :get-next-lesson-list="homeStore.getNextLessonList"
  />
  <Information
    :slider-info-list="homeStore.sliderInfoList"
    :grid-info-list="homeStore.gridInfoList"
    :list-info-list="homeStore.listInfoList"
  />
</template>
