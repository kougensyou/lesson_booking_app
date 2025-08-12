<script setup lang="ts">
import CustomizedSearch from '~/components/lessonBooking/customizedSearch.vue';
import StudioSearch from '~/components/lessonBooking/studioSearch.vue';
import { useLessonBookingStore } from '../stores/useLessonBookingStore';
import { useRouter } from 'vue-router';

const router = useRouter();
const lessonBookingStore = useLessonBookingStore();

const searchLessons = () => {
  lessonBookingStore.searchLessonsApi().then(() => {
    router.push({ path: '/searchedLesson' });
  });
};

await lessonBookingStore.getLessonBookingData();
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('lessonBooking.tabTitle') }}</title>
    </Head>
  </div>
  <StudioSearch :favorite-studio-list="lessonBookingStore.favoriteStudioList" />
  <CustomizedSearch
    :calendar-theme-color="lessonBookingStore.calendarThemeColor"
    :studio-list="lessonBookingStore.studioList"
    :lesson-category-list="lessonBookingStore.lessonCategoryList"
    :start-time-options="lessonBookingStore.startTimeOptions"
    :end-time-options="lessonBookingStore.endTimeOptions"
    :search-input-form="lessonBookingStore.searchInputForm"
    :search-lessons="searchLessons"
    :check-selected="lessonBookingStore.checkSelected"
    :change-by-prev="lessonBookingStore.changeByPrev"
    :change-by-next="lessonBookingStore.changeByNext"
    :remove-selected="lessonBookingStore.removeSelected"
    :add-selected="lessonBookingStore.addSelected"
  />
</template>
