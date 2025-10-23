<script setup lang="ts">
import type { Lesson } from '~/types/lesson';
import { onMounted, onUnmounted } from 'vue';

const props = defineProps<{
  lessonList: Array<Lesson>;
  addLessons: Function;
  loadedPage: number;
  lastPage: number;
  isLoading: boolean;
}>();

const scrollComponent = ref<HTMLElement | null>(null);

onMounted(() => {
  window.addEventListener('scroll', handleScroll);
});

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
});

/**
 * Handles scroll event to check if the user has scrolled to the bottom of the component.
 * If the user has scrolled to the bottom and the component is not loading and not at the last page,
 * calls the addLessons function to load more lessons.
 */
const handleScroll = () => {
  const element = scrollComponent.value;
  if (
    !props.isLoading &&
    element &&
    element.getBoundingClientRect().top + element.offsetHeight <
      window.innerHeight &&
    props.loadedPage < props.lastPage
  ) {
    props.addLessons();
  }
};
</script>
<template>
  <div ref="scrollComponent" class="scrolling-component bg-gray-100">
    <div
      v-for="(lesson, index) in lessonList"
      :key="index"
      class="bg-white border-b p-4 mt-2 mb-2"
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
