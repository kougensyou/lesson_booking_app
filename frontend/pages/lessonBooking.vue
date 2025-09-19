<script setup lang="ts">
import CustomizedSearch from '~/components/lessonBooking/CustomizedSearch.vue';
import StudioSearch from '~/components/lessonBooking/StudioSearch.vue';
import { useStudioStore } from '../stores/useStudioStore';
import { useLessonStore } from '../stores/useLessonStore';
import { useLessonBookingStore } from '~/stores/useLessonBookingStore';
import { useRouter } from 'vue-router';
import SpinLoading from '~/components/common/SpinLoading.vue';
import CardLoading from '~/components/common/CardLoading.vue';

definePageMeta({
  layout: 'bg-gradation',
});

const router = useRouter();
const studioStore = useStudioStore();
const lessonStore = useLessonStore();
const lessonBookingStore = useLessonBookingStore();

lessonBookingStore.setCalendarLocaleForLessonBooking();

const addSearchedLessons = () => {
  lessonStore.initializePaginationData();
  lessonStore.addSearchedLessonsApi().then(() => {
    router.push({ path: '/searchedLesson' });
  });
};

lessonStore.initializeSelectedDates();

studioStore.getStudioList();
studioStore.getFavoriteStudioList();
lessonStore.getLessonCategoryList();
lessonStore.getTimeOptions();
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('lessonBooking.tabTitle') }}</title>
    </Head>
  </div>
  <div
    v-if="studioStore.isFavoriteStudioLoading"
    class="flex items-center justify-center pt-12 pb-12"
  >
    <SpinLoading />
  </div>
  <StudioSearch
    v-if="!studioStore.isFavoriteStudioLoading"
    :favorite-studio-list="studioStore.favoriteStudioList"
  />

  <div
    v-if="
      studioStore.isStudioListLoading ||
      lessonStore.isLessonCategoryLoading ||
      lessonStore.isTimeOptionsLoading
    "
    class="px-4"
  >
    <CardLoading :card-height="'h-96'" :card-width="'w-full'" />
  </div>
  <CustomizedSearch
    v-if="
      !studioStore.isStudioListLoading &&
      !lessonStore.isLessonCategoryLoading &&
      !lessonStore.isTimeOptionsLoading
    "
    :calendar-theme-color="lessonStore.calendarThemeColor"
    :calendar-locale="lessonBookingStore.calendarLocale"
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
