<script setup lang="ts">
import menu from '~/assets/icons/menu.svg';
import close from '~/assets/icons/close.svg';
import Logo from '~/public/lesson-booking-logo.png';

defineProps<{
  isSidebarIcon: boolean;
  isOpen: boolean;
  toggleSidebar: () => void;
}>();
</script>
<template>
  <header :class="['shadow-md z-30 transition-colors duration-300']">
    <div class="flex items-center justify-between h-16 px-4">
      <div
        class="flex items-center space-x-1 cursor-pointer"
        @click="isSidebarIcon ? $router.push('/home') : $router.push('/')"
      >
        <img :src="Logo" alt="Logo" class="h-6" />
        <h1 class="text-xl font-bold text-sky-300">{{ $t('header.title') }}</h1>
      </div>
      <button
        v-if="isSidebarIcon"
        @click="toggleSidebar"
        class="flex items-center"
      >
        <img v-if="!isOpen" :src="menu" alt="Menu" />
        <img v-if="isOpen" :src="close" alt="Close" />
      </button>
    </div>
  </header>
</template>
