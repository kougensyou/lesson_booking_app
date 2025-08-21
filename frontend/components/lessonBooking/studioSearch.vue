<script setup lang="ts">
import HorizontalScroll from '../common/horizontalScroll.vue';
import type { FavoriteStudio } from '~/types/studio';

defineProps<{
  favoriteStudioList: Array<FavoriteStudio>;
}>();
</script>
<template>
  <div class="flex items-center px-4 pt-4">
    <h1 class="text-xl font-bold">
      {{ $t('lessonBooking.searchFromStudio') }}
    </h1>
    <button @click="" class="ml-auto">
      <span
        class="material-symbols-outlined"
        aria-hidden="true"
        @click="$router.push('/studioList')"
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
          class="min-w-[300px] h-[200px] bg-white rounded-xl shadow-md flex flex-col justify-between p-8"
        >
          <img
            :src="favoriteStudio.image_url"
            alt=""
            class="w-full h-32 object-cover rounded-t-lg"
          />
          <div class="p-3">
            <h3 class="text-base font-semibold">
              {{ favoriteStudio.studio_name }}
            </h3>
          </div>
        </NuxtLink>
      </div>
      <NuxtLink
        :to="{ path: '/studioList' }"
        class="min-w-[300px] h-[200px] bg-gray-100 rounded-xl shadow-md flex items-center justify-center p-8"
      >
        <span class="text-gray-500 text-sm">{{
          $t('lessonBooking.otherStudios')
        }}</span>
      </NuxtLink>
    </HorizontalScroll>
  </template>
  <template v-if="favoriteStudioList.length === 0">
    <NuxtLink
      :to="{ path: '/studioList' }"
      class="min-w-[300px] h-[200px] bg-gray-100 rounded-xl shadow-md flex items-center justify-center p-8"
    >
      <span class="text-gray-500 text-sm">{{
        $t('lessonBooking.otherStudios')
      }}</span>
    </NuxtLink>
  </template>
</template>
