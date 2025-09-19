<script setup lang="ts">
import HorizontalScroll from '../common/HorizontalScroll.vue';
import type { Studio } from '~/types/studio';

defineProps<{
  favoriteStudioList: Array<Studio>;
}>();
</script>
<template>
  <div class="flex items-center px-4 pt-4">
    <h1 class="text-xl font-bold">
      {{ $t('lessonBooking.searchFromStudio') }}
    </h1>
    <button class="ml-auto">
      <span
        class="material-symbols-outlined text-gray-800"
        aria-hidden="true"
        @click="$router.push('/studioForSearch')"
        >search</span
      >
    </button>
  </div>
  <template v-if="favoriteStudioList.length > 0">
    <HorizontalScroll>
      <div
        v-for="favoriteStudio in favoriteStudioList"
        :key="favoriteStudio.id"
      >
        <NuxtLink
          :to="{
            path: '/studioLesson',
            query: { studio_id: favoriteStudio.studio_id },
          }"
          class="min-w-[300px] h-[200px] bg-white rounded-3xl shadow-md flex flex-col justify-between"
        >
          <img
            :src="favoriteStudio.image_url"
            alt=""
            class="w-full h-40 object-cover rounded-t-lg"
          />
          <div class="p-2">
            <h3 class="text-base font-semibold">
              {{ favoriteStudio.studio_name }}
            </h3>
          </div>
        </NuxtLink>
      </div>
      <NuxtLink
        :to="{ path: '/studioForSearch' }"
        class="min-w-[300px] h-[200px] bg-gray-100 rounded-3xl shadow-md flex items-center justify-center"
      >
        <span class="text-gray-500 text-sm">{{
          $t('lessonBooking.otherStudios')
        }}</span>
      </NuxtLink>
    </HorizontalScroll>
  </template>
  <template v-if="favoriteStudioList.length === 0">
    <NuxtLink
      :to="{ path: '/studioForSearch' }"
      class="min-w-[300px] h-[200px] bg-gray-100 rounded-3xl shadow-md flex items-center justify-center"
    >
      <span class="text-gray-500 text-sm">{{
        $t('lessonBooking.otherStudios')
      }}</span>
    </NuxtLink>
  </template>
</template>
