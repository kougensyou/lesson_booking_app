<script setup>
import Footer from '../components/common/Footer.vue';
</script>
<template>
  <div class="min-h-screen bg-cover bg-center flex justify-center">
    <div
      class="w-full max-w-lg bg-white border border-gray-300 shadow-xl flex flex-col min-h-screen"
    >
      <main class="flex-1 bg-gray-100">
        <NuxtPage />
      </main>
      <Footer />
    </div>
  </div>
</template>
