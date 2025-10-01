<script setup lang="ts">
import menu from '~/assets/icons/menu.svg';
import close from '~/assets/icons/close.svg';

defineProps<{
  isSidebarIcon: boolean;
  isOpen: boolean;
  toggleSidebar: () => void;
}>();
</script>
<template>
  <header :class="['shadow-md z-30 transition-colors duration-300']">
    <div class="flex items-center justify-between h-16 px-4">
      <h1
        class="text-xl font-bold text-sky-300"
        @click="isSidebarIcon ? $router.push('/home') : $router.push('/')"
      >
        {{ $t('header.title') }}
      </h1>
      <button v-if="isSidebarIcon" @click="toggleSidebar">
        <img v-if="!isOpen" :src="menu" alt="Menu" />
        <img v-if="isOpen" :src="close" alt="Close" />
      </button>
    </div>
  </header>
</template>
