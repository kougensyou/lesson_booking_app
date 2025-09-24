<script setup lang="ts">
import { useLessonBookingStore } from '../stores/useLessonBookingStore';
import { useApiErrorHandler } from '~/composables/useApiErrorHandler';
import LessonList from '../components/common/LessonList.vue';
import SpinLoading from '~/components/common/SpinLoading.vue';

definePageMeta({
  middleware: 'auth',
});

const router = useRouter();

const lessonBookingStore = useLessonBookingStore();
lessonBookingStore.initializeBookingHistory();
lessonBookingStore.addBookingHistory().catch((error: any) => {
  useApiErrorHandler(router, error);
});
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('bookingHistory.tabTitle') }}</title>
    </Head>
  </div>

  <div
    v-if="lessonBookingStore.isBookingHistoryLoading"
    class="fixed inset-0 flex items-center justify-center"
  >
    <SpinLoading />
  </div>

  <LessonList
    v-if="!lessonBookingStore.isBookingHistoryLoading"
    :lesson-list="lessonBookingStore.bookingHistoryList"
    :add-lessons="lessonBookingStore.addBookingHistory"
    :loaded-page="lessonBookingStore.loadedPage"
    :last-page="lessonBookingStore.lastPage"
    :is-loading="lessonBookingStore.isBookingHistoryLoading"
  />
</template>
