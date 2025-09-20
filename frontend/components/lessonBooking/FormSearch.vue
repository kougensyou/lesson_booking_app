<script setup lang="ts">
import type { Studio } from '~/types/studio';
import type { LessonCategory, SearchInputForm } from '~/types/lesson';

defineProps<{
  studioList: Studio[];
  lessonCategoryList: LessonCategory[];
  searchInputForm: SearchInputForm;
  startTimeOptions: string[];
  endTimeOptions: string[];
}>();
</script>
<template>
  <div class="p-4">
    <div
      class="bg-white rounded-3xl shadow-md flex flex-col justify-between px-8 py-4 mb-4"
    >
      <span class="text-gray-800 text-sm pt-4 pb-2">
        {{ $t('lessonBooking.selectTime') }}
      </span>
      <div class="flex items-center space-x-2">
        <select
          v-model="searchInputForm.startTime"
          class="w-1/2 border p-1 rounded"
        >
          <option v-for="time in startTimeOptions" :key="time" :value="time">
            {{ time }}
          </option>
        </select>
        <span class="text-gray-800 text-sm">~</span>
        <select
          v-model="searchInputForm.endTime"
          class="w-1/2 border p-1 rounded"
        >
          <option v-for="time in endTimeOptions" :key="time" :value="time">
            {{ time }}
          </option>
        </select>
      </div>

      <span class="text-gray-800 text-sm pt-4 pb-2">
        {{ $t('lessonBooking.lessonCategory') }}
      </span>
      <select
        class="w-full border p-1 rounded"
        v-model="searchInputForm.lessonCategory"
      >
        <option value="">-</option>
        <option
          v-for="category in lessonCategoryList"
          :key="category.id"
          :value="category.id"
        >
          {{ category.category_name }}
        </option>
      </select>

      <span class="text-gray-800 text-sm pt-4 pb-2">
        {{ $t('lessonBooking.studio') }}
      </span>
      <select
        class="w-full border p-1 rounded"
        v-model="searchInputForm.studio"
      >
        <option value="">-</option>
        <option
          v-for="studio in studioList"
          :key="studio.id"
          :value="studio.id"
        >
          {{ studio.studio_name }}
        </option>
      </select>

      <span class="text-gray-800 text-sm pt-4 pb-2">
        {{ $t('lessonBooking.instructor') }}
      </span>
      <input
        class="w-full border p-1 rounded"
        type="text"
        v-model="searchInputForm.instructor"
      />

      <span class="text-gray-800 text-sm pt-4 pb-2">
        {{ $t('lessonBooking.lessonName') }}
      </span>
      <input
        class="w-full border p-1 rounded"
        type="text"
        v-model="searchInputForm.lessonName"
      />
    </div>
  </div>
</template>
