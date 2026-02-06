<script setup lang="ts">
import type { LessonDetail } from '~/types/lesson';
import SpinLoading from '../common/SpinLoading.vue';

defineProps<{
  lessonDetail: LessonDetail;
  isBookingStatusLoading: boolean;
  bookLesson: () => void;
  cancelLesson: () => void;
  closeDialog: () => void;
}>();
</script>
<template>
  <div class="fixed inset-0 bg-black bg-opacity-50 z-50"></div>
  <div
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
  >
    <div class="bg-white rounded-lg shadow-lg w-[80%] max-w-md p-6">
      <h2
        v-if="!lessonDetail.booked_flag"
        class="text-lg font-semibold mb-4 text-center"
      >
        {{ $t('lessonDetail.bookDialogMessage') }}
      </h2>
      <h2
        v-if="lessonDetail.booked_flag"
        class="text-lg font-semibold mb-4 text-center"
      >
        {{ $t('lessonDetail.cancelDialogMessage') }}
      </h2>

      <!-- Lesson Information -->
      <div class="border rounded-md p-4 flex items-start mb-6">
        <div class="text-center w-24 flex-shrink-0">
          <div class="text-sm font-semibold">
            {{ lessonDetail.studio_name }}
          </div>
          <div class="text-lg font-bold mt-1">
            {{ lessonDetail.lesson_day }}
          </div>
          <div class="text-sm">
            {{ lessonDetail.lesson_time }}
          </div>
        </div>
        <div class="ml-4 flex-1">
          <div class="font-semibold text-base mb-1 break-all w-full">
            {{ lessonDetail.lesson_name }}
          </div>
          <div class="text-sm text-gray-600 flex items-center space-x-2">
            <span class="font-medium">{{ lessonDetail.instructor_name }}</span>
          </div>
        </div>
      </div>

      <!-- Buttons -->
      <div class="max-w-md mx-auto space-y-4">
        <button
          v-if="!lessonDetail.booked_flag"
          class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 rounded-3xl font-semibold"
          @click="bookLesson"
        >
          <span v-if="!isBookingStatusLoading">{{
            $t('lessonDetail.bookConfirmed')
          }}</span>
          <span
            v-if="isBookingStatusLoading"
            class="flex items-center justify-center"
          >
            <SpinLoading :color="'#FFFFFF'" :width="'22px'" :height="'22px'" />
          </span>
        </button>
        <button
          v-if="lessonDetail.booked_flag"
          class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 rounded-3xl font-semibold"
          @click="cancelLesson"
        >
          <span v-if="!isBookingStatusLoading">{{
            $t('lessonDetail.cancelConfirmed')
          }}</span>
          <span
            v-if="isBookingStatusLoading"
            class="flex items-center justify-center"
          >
            <SpinLoading :color="'#FFFFFF'" :width="'22px'" :height="'22px'" />
          </span>
        </button>
        <button
          class="w-full border border-gray-300 text-gray-700 py-2 rounded-3xl"
          @click="closeDialog"
          :disabled="isBookingStatusLoading"
        >
          {{ $t('lessonDetail.backButton') }}
        </button>
      </div>
    </div>
  </div>
</template>
