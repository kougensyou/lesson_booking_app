<script setup lang="ts">
import { useLessonStore } from '../stores/useLessonStore';
import { useLessonBookingStore } from '~/stores/useLessonBookingStore';
import { useInformationStore } from '~/stores/useInformationStore';
import NextLesson from '~/components/home/NextLesson.vue';
import LessonCalendar from '~/components/home/LessonCalendar.vue';
import Information from '~/components/home/Information.vue';
import SpinLoader from '~/components/common/SpinLoader.vue';
import CardLoader from '~/components/common/CardLoader.vue';

const lessonStore = useLessonStore();
const lessonBookingStore = useLessonBookingStore();
const informationStore = useInformationStore();

lessonBookingStore.setCalendarLocaleForHome();

lessonStore.getNextLessonData();
lessonBookingStore.getSelectedLessonList();
informationStore.getInformationList();
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
    <SpinLoader />
  </div>
  <div v-if="lessonBookingStore.isSelectedLessonLoading" class="px-4">
    <CardLoader :card-height="'h-96'" :card-width="'w-full'" />
  </div>
  <div
    v-if="informationStore.isInformationLoading"
    class="flex items-center justify-center pt-12 pb-12"
  >
    <SpinLoader />
  </div>

  <NextLesson
    v-if="!lessonStore.isNextLessonLoading"
    :next-lesson-list="lessonStore.nextLessonList"
  />
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
  <Information
    v-if="!informationStore.isInformationLoading"
    :slider-info-list="informationStore.sliderInfoList"
    :grid-info-list="informationStore.gridInfoList"
    :list-info-list="informationStore.listInfoList"
  />
</template>
