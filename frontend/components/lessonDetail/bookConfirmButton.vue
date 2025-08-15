<script setup lang="ts">
defineProps<{
  openDialog: Function;
}>();
</script>
<template>
  <div class="fixed bottom-0 left-0 right-0 bg-white p-8">
    <div class="max-w-md mx-auto space-y-4">
      <button
        class="w-full bg-sky-500 text-white rounded-3xl py-4 relative"
        @click="openDialog"
      >
        <span>{{ $t('lessonDetail.bookButton') }}</span>
      </button>
      <div
        class="text-center text-sm text-blue-600 underline cursor-pointer"
        @click="$router.back()"
      >
        {{ $t('lessonDetail.backButton') }}
      </div>
    </div>
  </div>
</template>
