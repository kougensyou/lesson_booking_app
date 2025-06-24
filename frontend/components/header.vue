<script setup lang="ts">
defineProps<{
  isOpen: boolean;
  toggleSidebar: () => void;
}>();
</script>
<template>
  <header :class="['shadow-md z-30 transition-colors duration-300']">
    <div class="flex items-center justify-between h-16 px-4">
      <h1 class="text-xl font-bold text-green-600">{{ $t('header.title') }}</h1>
      <button @click="toggleSidebar">
        <span class="material-symbols-outlined">{{
          isOpen ? 'close' : 'menu'
        }}</span>
      </button>
    </div>
  </header>
</template>
