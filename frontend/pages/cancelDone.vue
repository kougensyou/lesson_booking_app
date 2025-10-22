<script setup lang="ts">
import { useLessonStore } from '../stores/useLessonStore';

definePageMeta({
  middleware: 'auth',
});

const lessonStore = useLessonStore();
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('cancelDone.tabTitle') }}</title>
    </Head>
  </div>

  <div class="p-4 max-w-md mx-auto">
    <!-- Canceled Lesson Information -->
    <h2 class="text-lg font-semibold text-center mb-4">
      {{ $t('cancelDone.cancelMessage') }}
    </h2>

    <div class="border p-4 rounded mb-4 bg-white">
      <div class="flex justify-between mb-2">
        <span class="font-bold">{{
          lessonStore.lessonDetail.studio_name
        }}</span>
        <span>{{ lessonStore.lessonDetail.lesson_datetime }}</span>
      </div>

      <div class="flex items-center justify-between">
        <span class="font-medium">{{
          lessonStore.lessonDetail.lesson_name
        }}</span>
      </div>

      <div class="text-sm mt-2 text-gray-600">
        {{ lessonStore.lessonDetail.instructor_name }}
      </div>
    </div>

    <!-- Buttons -->
    <div class="space-y-2">
      <button
        @click="$router.push({ path: '/lessonBooking' })"
        class="w-full bg-blue-600 text-white py-2 rounded"
      >
        {{ $t('cancelDone.continueBookingButton') }}
      </button>
      <button
        @click="$router.push({ path: '/memberInfo' })"
        class="w-full border border-gray-300 py-2 rounded"
      >
        {{ $t('cancelDone.toMyPageButton') }}
      </button>
    </div>
  </div>
</template>
