<script setup lang="ts">
import SpinLoading from '../common/SpinLoading.vue';

defineProps<{
  isAddLessonLoading: boolean;
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
        <span v-if="!isAddLessonLoading">{{
          $t('lessonBooking.searchButton')
        }}</span>
        <span
          v-if="isAddLessonLoading"
          class="flex items-center justify-center"
        >
          <SpinLoading :color="'#FFFFFF'" :width="'22px'" :height="'22px'" />
        </span>
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
