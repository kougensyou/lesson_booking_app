<script setup lang="ts">
import { useStudioStore } from '../stores/useStudioStore';

const studioStore = useStudioStore();
await studioStore.getFavoriteStudioList();
</script>
<template>
  <div class="p-4">
    <h1 class="text-lg font-bold text-center mb-4">
      {{ $t('favoriteStudio.pageTitle') }}
    </h1>

    <div
      v-for="studio in studioStore.favoriteStudioList"
      :key="studio.id"
      class="flex items-center mb-3"
    >
      <img
        :src="studio.image_url"
        class="w-24 h-16 rounded-lg object-cover mr-3"
      />
      <div class="flex-1">
        <div class="flex items-center">
          <span class="font-semibold">{{ studio.studio_name }}</span>
          <span class="ml-1 text-red-500">❤</span>
        </div>
      </div>
      <button class="ml-2 text-red-400 text-xl">－</button>
    </div>
    <div
      class="border-2 border-dashed rounded-lg py-4 text-center text-gray-500 mb-4"
    >
      {{ $t('favoriteStudio.searchStudio') }}
    </div>
    <button
      class="w-full py-2 rounded-2xl bg-blue-100 text-blue-600 font-semibold"
    >
      {{ $t('favoriteStudio.save') }}
    </button>
  </div>
</template>
