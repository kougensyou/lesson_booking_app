<script setup lang="ts">
defineProps<{ show: boolean; message: string }>();
</script>
<template>
  <transition name="fade">
    <div
      v-if="show"
      class="fixed top-4 inset-x-0 mx-auto w-[90%] max-w-md rounded-full bg-emerald-500 text-white text-center px-5 py-3 shadow-lg"
      role="status"
      aria-live="polite"
    >
      {{ message }}
    </div>
  </transition>
</template>
<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition:
    opacity 0.2s,
    transform 0.2s;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: translateY(-6px);
}
</style>
