<script setup lang="ts">
import type { Lesson } from '~/types/lesson';
import SpinLoading from '../common/SpinLoading.vue';

defineProps<{
  isNextLessonLoading: boolean;
  nextLessonList: Array<Lesson>;
}>();

const carouselConfig = {
  itemsToShow: 1.6,
  wrapAround: false,
  gap: 20,
  height: 200,
  snapAlign: 'start' as const,
};
</script>
<template>
  <h1 class="text-xl font-bold px-4 pt-4">{{ $t('home.nextLessonTitle') }}</h1>

  <div
    v-if="isNextLessonLoading"
    class="flex items-center justify-center pt-12 pb-12"
  >
    <SpinLoading />
  </div>

  <!-- No Next Lesson -->
  <template v-if="!isNextLessonLoading && nextLessonList.length === 0">
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

  <!-- Next Lesson -->
  <template v-if="!isNextLessonLoading && nextLessonList.length > 0">
    <div class="m-4">
      <Carousel v-bind="carouselConfig">
        <Slide
          v-for="lesson in nextLessonList"
          :key="lesson.id"
          class="carousel__slide h-[200px] bg-white rounded-3xl shadow-md flex flex-col justify-between p-8"
          @click="
            $router.push({
              path: '/lessonDetail',
              query: { lesson_id: lesson.id },
            })
          "
        >
          <div>
            <div class="text-md text-gray-500">{{ lesson.lesson_time }}</div>
            <div class="text-lg font-bold mt-1">
              {{ lesson.short_lesson_name }}
            </div>
          </div>
          <div>
            <div class="text-md text-gray-600 mt-2">
              {{ lesson.short_studio_name }}
            </div>
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
        </Slide>
      </Carousel>
    </div>
  </template>
</template>
<style>
.carousel__slide {
  align-items: flex-start;
}
</style>
