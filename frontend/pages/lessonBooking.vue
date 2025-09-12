<script setup lang="ts">
import CustomizedSearch from '~/components/lessonBooking/customizedSearch.vue';
import StudioSearch from '~/components/lessonBooking/studioSearch.vue';
import { useStudioStore } from '../stores/useStudioStore';
import { useLessonStore } from '../stores/useLessonStore';
import { useRouter } from 'vue-router';

const router = useRouter();
const studioStore = useStudioStore();
const lessonStore = useLessonStore();

const addSearchedLessons = () => {
  lessonStore.initializePaginationData();
  lessonStore.addSearchedLessonsApi().then(() => {
    router.push({ path: '/searchedLesson' });
  });
};

lessonStore.initializeSelectedDates();

await studioStore.getStudioList();
await studioStore.getFavoriteStudioList();
await lessonStore.getLessonCategoryList();
await lessonStore.getTimeOptions();
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('lessonBooking.tabTitle') }}</title>
    </Head>
  </div>
  <StudioSearch :favorite-studio-list="studioStore.favoriteStudioList" />
  <CustomizedSearch
    :calendar-theme-color="lessonStore.calendarThemeColor"
    :studio-list="studioStore.studioList"
    :lesson-category-list="lessonStore.lessonCategoryList"
    :start-time-options="lessonStore.startTimeOptions"
    :end-time-options="lessonStore.endTimeOptions"
    :search-input-form="lessonStore.searchInputForm"
    :add-searched-lessons="addSearchedLessons"
    :check-selected="lessonStore.checkSelected"
    :change-by-prev="lessonStore.changeByPrev"
    :change-by-next="lessonStore.changeByNext"
    :remove-selected="lessonStore.removeSelected"
    :add-selected="lessonStore.addSelected"
  />
</template>
