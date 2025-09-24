<script setup lang="ts">
import { useUserStore } from '../stores/useUserStore';
definePageMeta({
  layout: 'no-sidebar',
});
const userStore = useUserStore();
</script>
<template>
  <div class="flex flex-col items-center justify-center h-screen">
    <h1 class="text-3xl font-bold text-gray-700">404 Not Found</h1>
    <p class="mt-2">お探しのページは見つかりませんでした。</p>
    <a @click="userStore.logout" class="mt-4 underline">ログイン画面へ</a>
  </div>
</template>
