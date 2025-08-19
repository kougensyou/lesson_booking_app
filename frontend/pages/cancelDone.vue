<script setup lang="ts">
import { useLessonDetailStore } from '../stores/useLessonDetailStore';
const lessonDetailStore = useLessonDetailStore();
</script>
<template>
  <div class="p-4 max-w-md mx-auto">
    <h2 class="text-lg font-semibold text-center mb-4">
      {{ $t('cancelDone.cancelMessage') }}
    </h2>

    <div class="border p-4 rounded mb-4">
      <div class="flex justify-between mb-2">
        <span class="font-bold">{{
          lessonDetailStore.lessonDetail.studio_name
        }}</span>
        <span>{{ lessonDetailStore.lessonDetail.lesson_datetime }}</span>
      </div>

      <div class="flex items-center justify-between">
        <span class="font-medium">{{
          lessonDetailStore.lessonDetail.lesson_name
        }}</span>
      </div>

      <div class="text-sm mt-2 text-gray-600">
        {{ lessonDetailStore.lessonDetail.instructor_name }}
      </div>
    </div>

    <div class="space-y-2">
      <button
        @click="$router.push({ path: '/lessonBooking' })"
        class="w-full bg-blue-600 text-white py-2 rounded"
      >
        {{ $t('cancelDone.continueBookingButton') }}
      </button>
      <button
        @click="$router.push({ path: '/memberInfo' })"
        class="w-full border py-2 rounded"
      >
        {{ $t('cancelDone.toMyPageButton') }}
      </button>
    </div>
  </div>
</template>
