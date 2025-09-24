<script setup lang="ts">
import { useUserStore } from '../stores/useUserStore';
definePageMeta({
  layout: 'no-sidebar',
});

const userStore = useUserStore();
</script>
<template>
  <div class="flex flex-col items-center justify-center h-screen">
    <h1 class="text-3xl font-bold text-red-500">
      {{ $t('serverError.title') }}
    </h1>
    <p class="mt-2">
      {{ $t('serverError.message') }}
    </p>
    <a @click="userStore.logout" class="mt-4 underline">{{
      $t('serverError.toLogin')
    }}</a>
  </div>
</template>
