<script setup lang="ts">
defineProps<{
  cardHeight?: string;
  cardWidth?: string;
}>();
</script>
<template>
  <div
    :class="[
      `flex items-center justify-center bg-gray-300 rounded-3xl animate-pulse dark:bg-gray-700`,
      cardHeight,
      cardWidth,
    ]"
  >
    <span class="">Loading...</span>
  </div>
</template>
