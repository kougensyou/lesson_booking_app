<script setup lang="ts">
import { useLessonStore } from '../stores/useLessonStore';
import { useApiErrorHandler } from '~/composables/useApiErrorHandler';
import LessonList from '../components/common/LessonList.vue';
import SpinLoading from '~/components/common/SpinLoading.vue';

definePageMeta({
  middleware: 'auth',
});

const router = useRouter();

const lessonStore = useLessonStore();

lessonStore.initializePaginationData();
lessonStore
  .addSameStudioLessonList(lessonStore.lessonDetail.studio_id)
  .catch((error: any) => {
    useApiErrorHandler(router, error);
  });
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('bookDone.tabTitle') }}</title>
    </Head>
  </div>

  <div
    v-if="lessonStore.isAddLessonLoading"
    class="fixed inset-0 bg-opacity-50 z-50"
  ></div>

  <div class="p-4">
    <h2 class="text-xl font-bold text-center mb-4">
      {{ $t('bookDone.doneMessage') }}
    </h2>

    <div class="bg-white shadow-md rounded-lg p-4 mb-4">
      <div class="text-center text-2xl font-semibold mb-2">
        {{ lessonStore.lessonDetail.lesson_name }}
      </div>
      <div class="text-center text-2xl font-semibold my-2">
        {{ lessonStore.lessonDetail.lesson_datetime }}
      </div>
      <div class="text-center text-sm text-gray-500">
        {{ lessonStore.lessonDetail.studio_name }}
      </div>
    </div>

    <button
      class="w-full bg-orange-500 text-white py-2 rounded-md font-semibold hover:bg-orange-600"
      @click="
        $router.push({
          path: '/lessonBooking',
        })
      "
    >
      {{ $t('bookDone.continueBookingButton') }}
    </button>

    <div
      v-if="lessonStore.isAddLessonLoading"
      class="flex items-center justify-center pt-12 pb-12"
    >
      <SpinLoading />
    </div>

    <div v-if="!lessonStore.isAddLessonLoading" class="mt-6">
      <h3 class="font-semibold mb-2">
        {{ $t('bookDone.recommended') }}
      </h3>

      <LessonList
        :lesson-list="lessonStore.sameStudioLessonList"
        :add-lessons="lessonStore.addSameStudioLessonList"
        :loaded-page="lessonStore.loadedPage"
        :last-page="lessonStore.lastPage"
        :is-loading="lessonStore.isAddLessonLoading"
      />
    </div>
  </div>
</template>
