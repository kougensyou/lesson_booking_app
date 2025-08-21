<script setup lang="ts">
import type { LessonDetail } from '~/types/lesson';

defineProps<{
  lessonDetail: LessonDetail;
  bookLesson: Function;
  cancelLesson: Function;
  closeDialog: Function;
}>();
</script>
<template>
  <div class="fixed inset-0 bg-black bg-opacity-50 z-50"></div>
  <div
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
  >
    <div class="bg-white rounded-lg shadow-lg w-[80%] max-w-md p-6">
      <h2
        v-if="!lessonDetail.reserved_flag"
        class="text-lg font-semibold mb-4 text-center"
      >
        {{ $t('lessonDetail.bookDialogMessage') }}
      </h2>
      <h2
        v-if="lessonDetail.reserved_flag"
        class="text-lg font-semibold mb-4 text-center"
      >
        {{ $t('lessonDetail.cancelDialogMessage') }}
      </h2>

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
          <div class="font-semibold text-base mb-1">
            {{ lessonDetail.lesson_name }}
          </div>
          <div class="text-sm text-gray-600 flex items-center space-x-2">
            <span class="font-medium">{{ lessonDetail.instructor_name }}</span>
          </div>
        </div>
      </div>
      <div class="max-w-md mx-auto space-y-4">
        <button
          v-if="!lessonDetail.reserved_flag"
          class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 rounded-3xl font-semibold"
          @click="bookLesson"
        >
          {{ $t('lessonDetail.bookConfirmed') }}
        </button>
        <button
          v-if="lessonDetail.reserved_flag"
          class="w-full bg-orange-500 hover:bg-orange-600 text-white py-2 rounded-3xl font-semibold"
          @click="cancelLesson"
        >
          {{ $t('lessonDetail.cancelConfirmed') }}
        </button>
        <button
          class="w-full border border-gray-300 text-gray-700 py-2 rounded-3xl"
          @click="closeDialog"
        >
          {{ $t('lessonDetail.backButton') }}
        </button>
      </div>
    </div>
  </div>
</template>
