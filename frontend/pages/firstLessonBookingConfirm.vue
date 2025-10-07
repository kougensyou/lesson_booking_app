<script setup lang="ts">
import { useLessonBookingStore } from '~/stores/useLessonBookingStore';
import { useApiErrorHandler } from '~/composables/useApiErrorHandler';
import FirstUser from '~/components/firstLessonBookingConfirm/FirstUser.vue';
import ConfirmDialog from '~/components/firstLessonBookingConfirm/ConfirmDialog.vue';
import { useRouter } from 'vue-router';

definePageMeta({
  layout: 'no-sidebar',
});

const lessonBookingStore = useLessonBookingStore();

const router = useRouter();

const applyFirstLesson = () => {
  lessonBookingStore
    .applyFirstLessonApi()
    .then(() => {
      router.push({ path: '/firstLessonBookingDone' });
    })
    .catch((error: any) => {
      useApiErrorHandler(router, error);
    });
};
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('firstLessonBookingConfirm.tabTitle') }}</title>
    </Head>
  </div>

  <div
    v-if="lessonBookingStore.isFirstBookingLoading"
    class="fixed inset-0 bg-opacity-50 z-50"
  ></div>

  <div class="px-4 py-3 space-y-6">
    <div class="border rounded p-4 flex items-start mb-6 bg-white">
      <div class="text-center w-24 flex-shrink-0">
        <div class="text-sm font-semibold">
          {{ lessonBookingStore.firstBooking.selectedLesson.studio_name }}
        </div>
        <div class="text-lg font-bold mt-1">
          {{ lessonBookingStore.firstBooking.selectedLesson.lesson_day }}
        </div>
        <div class="text-sm">
          {{ lessonBookingStore.firstBooking.selectedLesson.lesson_time }}
        </div>
      </div>
      <div class="ml-4 flex-1">
        <div class="font-semibold text-base mb-1 break-all w-full">
          {{ lessonBookingStore.firstBooking.selectedLesson.lesson_name }}
        </div>
      </div>
    </div>

    <FirstUser :user="lessonBookingStore.firstBooking.user" />

    <button
      class="mt-12 bg-sky-500 rounded-3xl py-4 w-full relative"
      @click="lessonBookingStore.openDialog()"
    >
      <span class="text-white">{{ $t('firstLessonBookingConfirm.book') }}</span>
      <span
        class="text-white material-symbols-outlined absolute right-3"
        aria-hidden="true"
      >
        chevron_right
      </span>
    </button>

    <ConfirmDialog
      v-if="lessonBookingStore.isDialogOpen"
      :is-first-booking-loading="lessonBookingStore.isFirstBookingLoading"
      :selected-lesson="lessonBookingStore.firstBooking.selectedLesson"
      :apply-first-lesson="applyFirstLesson"
      :close-dialog="lessonBookingStore.closeDialog"
    />
  </div>
</template>
