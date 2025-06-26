<script setup>
import Footer from '../components/footer.vue';
</script>
<template>
  <div class="min-h-screen bg-cover bg-center flex justify-center px-4">
    <div
      class="w-full max-w-lg bg-white border border-gray-300 shadow-xl rounded-xl flex flex-col min-h-screen"
    >
      <main class="flex-1">
        <NuxtPage />
      </main>
      <Footer />
    </div>
  </div>
</template>
