<script setup lang="ts">
import { useLessonBookingStore } from '../stores/useLessonBookingStore';
import LessonList from '../components/common/lessonList.vue';

const lessonBookingStore = useLessonBookingStore();
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
  />
</template>
