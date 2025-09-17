<script setup>
import Header from '../components/common/Header.vue';
import Footer from '../components/common/Footer.vue';
import { ref } from 'vue';

const isSidebarIcon = ref(false);
const isOpen = ref(false);
</script>
<template>
  <div class="min-h-screen bg-cover bg-center flex justify-center">
    <div
      class="w-full max-w-lg bg-white border border-gray-300 shadow-xl flex flex-col min-h-screen"
    >
      <Header :is-sidebar-icon="isSidebarIcon" :is-open="isOpen" />
      <main class="flex-1 bg-gray-100">
        <NuxtPage />
      </main>
      <Footer />
    </div>
  </div>
</template>
