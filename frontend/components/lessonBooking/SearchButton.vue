<script setup lang="ts">
defineProps<{
  addSearchedLessons: Function;
}>();
</script>
<template>
  <div class="fixed bottom-0 left-0 right-0 bg-white px-4 py-4">
    <div class="max-w-md mx-auto">
      <button
        class="w-full bg-sky-500 text-white rounded-3xl py-4 relative"
        @click="addSearchedLessons"
      >
        <span>{{ $t('lessonBooking.searchButton') }}</span>
        <span
          class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2"
          aria-hidden="true"
        >
          chevron_right
        </span>
      </button>
    </div>
  </div>
</template>
