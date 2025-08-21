<script setup lang="ts">
import { useLessonStore } from '../stores/useLessonStore';
import LessonList from '../components/common/lessonList.vue';

const lessonStore = useLessonStore();
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('lessonBooking.tabTitle') }}</title>
    </Head>
  </div>
  <LessonList :lesson-list="lessonStore.searchedLessonList" />
</template>
