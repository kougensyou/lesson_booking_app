<script setup lang="ts">
import { useLessonStore } from '../stores/useLessonStore';
import LessonList from '../components/common/LessonList.vue';

const lessonStore = useLessonStore();
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('lessonBooking.tabTitle') }}</title>
    </Head>
  </div>
  <LessonList
    :lesson-list="lessonStore.searchedLessonList"
    :add-lessons="lessonStore.addSearchedLessonsApi"
    :loaded-page="lessonStore.loadedPage"
    :last-page="lessonStore.lastPage"
    :is-loading="lessonStore.isLoading"
    :change-is-loading="lessonStore.changeIsLoading"
  />
</template>
