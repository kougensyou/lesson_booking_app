<script setup lang="ts">
import type { Lesson } from '~/types/lesson';
import HorizontalScroll from '../common/HorizontalScroll.vue';

defineProps<{
  nextLessonList: Array<Lesson>;
}>();
</script>
<template>
  <h1 class="text-xl font-bold px-4 pt-4">{{ $t('home.nextLessonTitle') }}</h1>
  <template v-if="nextLessonList.length === 0">
    <div class="px-4 py-2">
      <div class="flex flex-col items-center justify-center space-y-4 p-4">
        <span class="text-gray-500 text-sm">{{
          $t('home.noBookingLessons')
        }}</span>
        <button
          class="w-3/5 bg-sky-500 text-white rounded-3xl py-4"
          @click="$router.push({ path: '/lessonBooking' })"
        >
          <span class="text-white">{{ $t('home.bookLesson') }}</span>
        </button>
      </div>
    </div>
  </template>
  <template v-if="nextLessonList.length > 0">
    <HorizontalScroll>
      <div
        v-for="lesson in nextLessonList"
        :key="lesson.id"
        class="min-w-[300px] h-[200px] bg-white rounded-3xl shadow-md flex flex-col justify-between p-8"
        @click="
          $router.push({
            path: '/lessonDetail',
            query: { lesson_id: lesson.id },
          })
        "
      >
        <div>
          <div class="text-md text-gray-500">{{ lesson.lesson_time }}</div>
          <div class="text-lg font-bold mt-1">{{ lesson.lesson_name }}</div>
        </div>
        <div>
          <div class="text-md text-gray-600 mt-2">{{ lesson.studio_name }}</div>
          <div class="flex items-center mt-2">
            <img
              :src="lesson.image_url"
              alt="Instructor"
              class="w-8 h-8 rounded-full mr-2"
              draggable="false"
            />
            <div class="text-md text-gray-800">
              {{ lesson.instructor_name }}
            </div>
          </div>
        </div>
      </div>
    </HorizontalScroll>
  </template>
</template>
