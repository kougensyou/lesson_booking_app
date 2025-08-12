<script setup lang="ts">
import { useLessonBookingStore } from '../stores/useLessonBookingStore';

const lessonBookingStore = useLessonBookingStore();
</script>
<template>
  <div class="p-4">
    <div class="flex items-center mt-4 bg-gray-100 rounded px-3 py-2">
      <span class="material-symbols-outlined" aria-hidden="true">search</span>
      <input
        type="text"
        placeholder="スタジオ名検索"
        class="flex-1 bg-transparent outline-none ml-2"
      />
    </div>
    <div
      v-for="(studio, i) in lessonBookingStore.studioList"
      :key="i"
      class="flex items-center mb-3"
    >
      <span class="flex-1">{{ studio.studio_name }}</span>
    </div>
  </div>
</template>
