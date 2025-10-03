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
import RectLoading from '~/components/common/RectLoading.vue';

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

  <StudioSearch
    :is-favorite-studio-loading="studioStore.isFavoriteStudioLoading"
    :favorite-studio-list="studioStore.favoriteStudioList"
  />

  <h1 class="text-xl font-bold px-4 pt-4">
    {{ $t('lessonBooking.customizedSearch') }}
  </h1>

  <div
    v-if="
      studioStore.isStudioListLoading ||
      lessonStore.isLessonCategoryLoading ||
      lessonStore.isTimeOptionsLoading
    "
  >
    <RectLoading :card-height="'360px'" :card-width="'w-full'" />
    <span class="space-y-4"></span>
    <RectLoading :card-height="'400px'" :card-width="'w-full'" />
  </div>

  <template
    v-if="
      !studioStore.isStudioListLoading &&
      !lessonStore.isLessonCategoryLoading &&
      !lessonStore.isTimeOptionsLoading
    "
  >
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
  </template>

  <SearchButton
    :is-add-lesson-loading="lessonStore.isAddLessonLoading"
    :add-searched-lessons="addSearchedLessons"
  />
</template>
