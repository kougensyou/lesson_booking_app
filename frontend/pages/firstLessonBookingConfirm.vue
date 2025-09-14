<script setup lang="ts">
import { useLessonBookingStore } from '~/stores/useLessonBookingStore';
import FirstUser from '~/components/firstLessonBookingConfirm/FirstUser.vue';
import ConfirmDialog from '~/components/firstLessonBookingConfirm/ConfirmDialog.vue';

definePageMeta({
  layout: 'no-header',
});

const lessonBookingStore = useLessonBookingStore();
</script>
<template>
  <div class="px-4 py-3 space-y-6">
    <div class="border rounded-md p-4 flex items-start mb-6">
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
        <div class="font-semibold text-base mb-1">
          {{ lessonBookingStore.firstBooking.selectedLesson.lesson_name }}
        </div>
      </div>
    </div>

    <FirstUser :user="lessonBookingStore.firstBooking.user" />

    <button
      class="mt-12 pt-6 pb-6 pl-3 pr-3 bg-sky-500 rounded-3xl w-full relative"
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
      :selected-lesson="lessonBookingStore.firstBooking.selectedLesson"
      :apply-first-lesson="lessonBookingStore.applyFirstLesson"
      :close-dialog="lessonBookingStore.closeDialog"
    />
  </div>
</template>
