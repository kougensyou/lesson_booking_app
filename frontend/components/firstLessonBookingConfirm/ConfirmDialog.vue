<script setup lang="ts">
import type { FirstSelectedLesson } from '~/types/lessonBooking';
import SpinLoading from '../common/SpinLoading.vue';

defineProps<{
  isFirstBookingLoading: boolean;
  selectedLesson: FirstSelectedLesson;
  applyFirstLesson: Function;
  closeDialog: Function;
}>();
</script>
<template>
  <div class="fixed inset-0 bg-black bg-opacity-50 z-50"></div>
  <div
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
  >
    <div class="bg-white rounded-lg shadow-lg w-[80%] max-w-md p-6">
      <h2 class="text-lg font-semibold mb-4 text-center">
        {{ $t('firstLessonBookingConfirm.bookDialogMessage') }}
      </h2>

      <div class="border rounded-md p-4 flex items-start mb-6">
        <div class="text-center w-24 flex-shrink-0">
          <div class="text-sm font-semibold">
            {{ selectedLesson.studio_name }}
          </div>
          <div class="text-lg font-bold mt-1">
            {{ selectedLesson.lesson_day }}
          </div>
          <div class="text-sm">
            {{ selectedLesson.lesson_time }}
          </div>
        </div>
        <div class="ml-4 flex-1">
          <div class="font-semibold text-base mb-1 break-all w-full">
            {{ selectedLesson.lesson_name }}
          </div>
        </div>
      </div>
      <div class="max-w-md mx-auto space-y-4">
        <button
          class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 rounded-3xl font-semibold"
          @click="applyFirstLesson()"
        >
          <span v-if="!isFirstBookingLoading">
            {{ $t('firstLessonBookingConfirm.book') }}
          </span>
          <span
            v-if="isFirstBookingLoading"
            class="flex items-center justify-center"
          >
            <SpinLoading :color="'#FFFFFF'" :width="'22px'" :height="'22px'" />
          </span>
        </button>
        <button
          class="w-full border border-gray-300 text-gray-700 py-2 rounded-3xl"
          @click="closeDialog()"
          :disabled="isFirstBookingLoading"
        >
          {{ $t('firstLessonBookingConfirm.back') }}
        </button>
      </div>
    </div>
  </div>
</template>
