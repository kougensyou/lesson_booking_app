<script setup lang="ts">
import CustomizedSearch from '~/components/lessonBooking/customizedSearch.vue';
import StudioSearch from '~/components/lessonBooking/studioSearch.vue';
import { useLessonBookingStore } from '../stores/useLessonBookingStore';

const lessonBookingStore = useLessonBookingStore();

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
  />
</template>
