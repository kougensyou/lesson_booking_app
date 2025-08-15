<script setup lang="ts">
import { useLessonBookingStore } from '../stores/useLessonBookingStore';

const lessonBookingStore = useLessonBookingStore();
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('lessonBooking.tabTitle') }}</title>
    </Head>
  </div>
  <div class="space-y-4 bg-gray-100">
    <div
      v-for="(lesson, index) in lessonBookingStore.searchedLessonList"
      :key="index"
      class="bg-white border-b p-4"
      @click="
        $router.push({
          path: '/lessonDetail',
          query: { lesson_id: lesson.id },
        })
      "
    >
      <p class="text-sm text-gray-600">{{ lesson.lesson_time }}</p>
      <p class="font-bold">{{ lesson.lesson_name }}</p>
      <p class="text-sm text-gray-600">{{ lesson.studio_name }}</p>
      <div class="flex items-center mt-1 space-x-2">
        <img :src="lesson.image_url" alt="" class="w-8 h-8 rounded-full" />
        <span>{{ lesson.instructor_name }}</span>
      </div>
    </div>
  </div>
</template>
