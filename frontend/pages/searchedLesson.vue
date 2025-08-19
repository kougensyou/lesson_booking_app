<script setup lang="ts">
import { useLessonBookingStore } from '../stores/useLessonBookingStore';
import LessonList from '../components/common/lessonList.vue';

const lessonBookingStore = useLessonBookingStore();
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('lessonBooking.tabTitle') }}</title>
    </Head>
  </div>
  <LessonList :lesson-list="lessonBookingStore.searchedLessonList" />
</template>
