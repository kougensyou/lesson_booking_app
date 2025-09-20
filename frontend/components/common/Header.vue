<script setup lang="ts">
defineProps<{
  isSidebarIcon: boolean;
  isOpen: boolean;
  toggleSidebar: () => void;
}>();
</script>
<template>
  <header :class="['shadow-md z-30 transition-colors duration-300']">
    <div class="flex items-center justify-between h-16 px-4">
      <h1 class="text-xl font-bold text-sky-300" @click="$router.push('/home')">
        {{ $t('header.title') }}
      </h1>
      <button v-if="isSidebarIcon" @click="toggleSidebar">
        <span
          class="material-symbols-outlined text-gray-800"
          aria-hidden="true"
          >{{ isOpen ? 'close' : 'menu' }}</span
        >
      </button>
    </div>
  </header>
</template>
