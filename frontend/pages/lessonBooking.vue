<script setup lang="ts">
import CalendarSearch from '~/components/lessonBooking/CalendarSearch.vue';
import SearchButton from '~/components/lessonBooking/SearchButton.vue';
import FormSearch from '~/components/lessonBooking/FormSearch.vue';
import StudioSearch from '~/components/lessonBooking/StudioSearch.vue';
import { useStudioStore } from '../stores/useStudioStore';
import { useLessonStore } from '../stores/useLessonStore';
import { useLessonBookingStore } from '~/stores/useLessonBookingStore';
import { useRouter } from 'vue-router';
import { useApiErrorHandler } from '~/composables/useApiErrorHandler';
import SpinLoading from '~/components/common/SpinLoading.vue';
import CardLoading from '~/components/common/CardLoading.vue';

definePageMeta({
  layout: 'bg-gradation',
  middleware: 'auth',
});

const router = useRouter();
const studioStore = useStudioStore();
const lessonStore = useLessonStore();
const lessonBookingStore = useLessonBookingStore();

lessonBookingStore.setCalendarLocaleForLessonBooking();

const addSearchedLessons = () => {
  lessonStore.initializePaginationData();
  lessonStore
    .addSearchedLessonsApi()
    .then(() => {
      router.push({ path: '/searchedLesson' });
    })
    .catch((error: any) => {
      useApiErrorHandler(router, error);
    });
};

lessonStore.initializeSelectedDates();

studioStore.getStudioList().catch((error: any) => {
  useApiErrorHandler(router, error);
});
studioStore.getFavoriteStudioList().catch((error: any) => {
  useApiErrorHandler(router, error);
});
lessonStore.getLessonCategoryList().catch((error: any) => {
  useApiErrorHandler(router, error);
});
lessonStore.getTimeOptions().catch((error: any) => {
  useApiErrorHandler(router, error);
});
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

  <template
    v-if="
      !studioStore.isStudioListLoading &&
      !lessonStore.isLessonCategoryLoading &&
      !lessonStore.isTimeOptionsLoading
    "
  >
    <h1 class="text-xl font-bold px-4 pt-4">
      {{ $t('lessonBooking.customizedSearch') }}
    </h1>

    <CalendarSearch
      :calendar-theme-color="lessonStore.calendarThemeColor"
      :calendar-locale="lessonBookingStore.calendarLocale"
      :check-selected="lessonStore.checkSelected"
      :change-by-prev="lessonStore.changeByPrev"
      :change-by-next="lessonStore.changeByNext"
      :remove-selected="lessonStore.removeSelected"
      :add-selected="lessonStore.addSelected"
    />

    <FormSearch
      :studio-list="studioStore.studioList"
      :lesson-category-list="lessonStore.lessonCategoryList"
      :search-input-form="lessonStore.searchInputForm"
      :start-time-options="lessonStore.startTimeOptions"
      :end-time-options="lessonStore.endTimeOptions"
    />

    <SearchButton :add-searched-lessons="addSearchedLessons" />
  </template>
</template>
