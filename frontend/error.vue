<script setup lang="ts">
definePageMeta({
  layout: 'no-sidebar',
});
</script>
<template>
  <div class="flex flex-col items-center justify-center h-screen">
    <h1 class="text-3xl font-bold text-red-600">{{ $t('error.title') }}</h1>
    <p class="mt-2">
      {{ $t('error.message') }}
    </p>
  </div>
</template>
