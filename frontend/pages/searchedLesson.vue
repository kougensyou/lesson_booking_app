<script setup lang="ts">
import { useLessonStore } from '../stores/useLessonStore';
import { useApiErrorHandler } from '~/composables/useApiErrorHandler';
import { useRouter } from 'vue-router';
import LessonList from '../components/common/LessonList.vue';
import SpinLoading from '~/components/common/SpinLoading.vue';

definePageMeta({
  middleware: 'auth',
});

const router = useRouter();

const lessonStore = useLessonStore();

const addSearchedLessons = () => {
  lessonStore.addSearchedLessonsApi().catch((error: any) => {
    useApiErrorHandler(router, error);
  });
};
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('lessonBooking.tabTitle') }}</title>
    </Head>
  </div>

  <div
    v-if="lessonStore.isAddLessonLoading"
    class="fixed inset-0 flex items-center justify-center"
  >
    <SpinLoading />
  </div>

  <LessonList
    v-if="!lessonStore.isAddLessonLoading"
    :lesson-list="lessonStore.searchedLessonList"
    :add-lessons="addSearchedLessons"
    :loaded-page="lessonStore.loadedPage"
    :last-page="lessonStore.lastPage"
    :is-loading="lessonStore.isAddLessonLoading"
  />
</template>
