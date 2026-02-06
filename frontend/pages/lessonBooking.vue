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
    v-if="
      lessonStore.isAddLessonLoading ||
      studioStore.isStudioLoading ||
      lessonStore.isLessonCategoryLoading ||
      lessonStore.isTimeOptionsLoading
    "
    class="fixed inset-0 bg-opacity-50 z-50"
  ></div>

  <!-- Studio Search -->
  <StudioSearch
    :is-favorite-studio-loading="studioStore.isFavoriteStudioLoading"
    :favorite-studio-list="studioStore.favoriteStudioList"
  />

  <!-- Customized Search -->
  <h1 class="text-xl font-bold px-4 pt-4">
    {{ $t('lessonBooking.customizedSearch') }}
  </h1>

  <div
    v-if="
      studioStore.isStudioLoading ||
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
      !studioStore.isStudioLoading &&
      !lessonStore.isLessonCategoryLoading &&
      !lessonStore.isTimeOptionsLoading
    "
  >
    <CalendarSearch
      :calendar-theme-color="lessonBookingStore.calendarThemeColor"
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

  <!-- Search Button -->
  <SearchButton
    :is-add-lesson-loading="lessonStore.isAddLessonLoading"
    :search-lessons="
      () => {
        router.push({ path: '/searchedLesson' });
      }
    "
  />
</template>
