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

lessonStore.initializePaginationData();
lessonStore
  .addSearchedLessonsApi()
  .then(() => {
    router.push({ path: '/searchedLesson' });
  })
  .catch((error: any) => {
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
    v-if="lessonStore.isAddLessonLoading"
    class="fixed inset-0 bg-opacity-50 z-50"
  ></div>

  <div
    v-if="lessonStore.isAddLessonLoading"
    class="fixed inset-0 flex items-center justify-center"
  >
    <SpinLoading />
  </div>

  <div
    v-if="
      !lessonStore.isAddLessonLoading &&
      lessonStore.searchedLessonList.length === 0
    "
    class="flex flex-col items-center justify-center h-screen space-y-4"
  >
    <span class="text-gray-500 text-sm">{{
      $t('lessonBooking.noSearchedLessons')
    }}</span>
    <button
      class="w-3/5 bg-sky-500 text-white rounded-3xl py-4"
      @click="$router.push({ path: '/lessonBooking' })"
    >
      <span class="text-white">{{ $t('lessonBooking.back') }}</span>
    </button>
  </div>

  <LessonList
    v-if="lessonStore.searchedLessonList.length > 0"
    :lesson-list="lessonStore.searchedLessonList"
    :add-lessons="addSearchedLessons"
    :loaded-page="lessonStore.loadedPage"
    :last-page="lessonStore.lastPage"
    :is-loading="lessonStore.isAddLessonLoading"
  />
</template>
