<script setup lang="ts">
import { useLessonBookingStore } from '../stores/useLessonBookingStore';
import LessonList from '../components/common/LessonList.vue';

const lessonBookingStore = useLessonBookingStore();
lessonBookingStore.initializeBookingHistory();
await lessonBookingStore.addBookingHistory();
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('bookingHistory.tabTitle') }}</title>
    </Head>
  </div>
  <LessonList
    :lesson-list="lessonBookingStore.bookingHistoryList"
    :add-lessons="lessonBookingStore.addBookingHistory"
    :loaded-page="lessonBookingStore.loadedPage"
    :last-page="lessonBookingStore.lastPage"
    :is-loading="lessonBookingStore.isLoading"
    :change-is-loading="lessonBookingStore.changeIsLoading"
  />
</template>
