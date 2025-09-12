<script setup lang="ts">
import type { LessonCategory } from '~/types/lesson';
import type { FirstSelectedLesson } from '~/types/lessonBooking';
import type { Studio } from '~/types/studio';

defineProps<{
  selectedLesson: FirstSelectedLesson;
  studioList: Array<Studio>;
  lessonCategoryList: Array<LessonCategory>;
}>();
</script>
<template>
  <div>
    <label class="block text-sm font-medium">{{
      $t('firstLessonBooking.lessonCategory')
    }}</label>
    <select
      class="w-full border p-1 rounded"
      v-model="selectedLesson.lesson_category_name"
    >
      <option value="">-</option>
      <option
        v-for="category in lessonCategoryList"
        :key="category.id"
        :value="category.category_name"
      >
        {{ category.category_name }}
      </option>
    </select>
  </div>

  <div>
    <label class="block text-sm font-medium">{{
      $t('firstLessonBooking.studio')
    }}</label>
    <select
      class="w-full border p-1 rounded"
      v-model="selectedLesson.studio_name"
    >
      <option value="">-</option>
      <option
        v-for="studio in studioList"
        :key="studio.id"
        :value="studio.studio_name"
      >
        {{ studio.studio_name }}
      </option>
    </select>
  </div>
</template>
