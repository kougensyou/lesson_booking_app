<script setup>
import Header from '../components/common/Header.vue';
import Footer from '../components/common/Footer.vue';
import Sidebar from '~/components/common/Sidebar.vue';
import { ref } from 'vue';

const isSidebarIcon = ref(true);
const isOpen = ref(false);

const toggleSidebar = () => {
  isOpen.value = !isOpen.value;
};

const closeSidebar = () => {
  isOpen.value = false;
};
</script>
<template>
  <div class="min-h-screen bg-cover bg-center flex justify-center">
    <div
      class="w-full max-w-lg bg-white border border-gray-300 shadow-xl flex flex-col min-h-screen"
    >
      <Sidebar :is-open="isOpen" :close-sidebar="closeSidebar" />
      <Header
        :is-sidebar-icon="isSidebarIcon"
        :is-open="isOpen"
        :toggle-sidebar="toggleSidebar"
        :close-sidebar="closeSidebar"
      />
      <main class="flex-1 bg-gradient-to-b from-[#E5FCFF] to-[#F9F9F9]">
        <NuxtPage />
      </main>
      <Footer />
    </div>
  </div>
</template>
