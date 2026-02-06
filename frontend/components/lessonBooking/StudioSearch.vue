<script setup lang="ts">
import type { Studio } from '~/types/studio';
import SpinLoading from '../common/SpinLoading.vue';

defineProps<{
  isFavoriteStudioLoading: boolean;
  favoriteStudioList: Array<Studio>;
}>();

const carouselConfig = {
  itemsToShow: 1.6,
  wrapAround: false,
  gap: 20,
  height: 200,
  snapAlign: 'start' as const,
};
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

  <div
    v-if="isFavoriteStudioLoading"
    class="flex items-center justify-center pt-12 pb-12"
  >
    <SpinLoading />
  </div>

  <!-- Studio List -->
  <template v-if="!isFavoriteStudioLoading && favoriteStudioList.length > 0">
    <div class="m-4">
      <Carousel v-bind="carouselConfig">
        <Slide
          v-for="favoriteStudio in favoriteStudioList"
          :key="favoriteStudio.id"
          class="min-w-[250px] h-[200px] bg-white rounded-3xl shadow-md flex flex-col justify-between items-start"
          @click="
            $router.push({
              path: '/studioLesson',
              query: { studio_id: favoriteStudio.id },
            })
          "
        >
          <img
            :src="favoriteStudio.image_url"
            alt=""
            class="w-full h-40 object-cover rounded-t-3xl"
          />
          <div class="pl-4 pb-2">
            <h3 class="text-base font-semibold">
              {{ favoriteStudio.short_studio_name }}
              <span class="text-red-500">❤</span>
            </h3>
          </div>
        </Slide>
      </Carousel>
    </div>
  </template>

  <!-- No Studio -->
  <template v-if="!isFavoriteStudioLoading && favoriteStudioList.length === 0">
    <div class="ml-4 mr-4">
      <NuxtLink
        :to="{ path: '/studioForSearch' }"
        class="min-w-[300px] h-[200px] bg-gray-100 rounded-3xl shadow-md flex items-center justify-center"
      >
        <span class="text-gray-500 text-sm">{{
          $t('lessonBooking.otherStudios')
        }}</span>
      </NuxtLink>
    </div>
  </template>
</template>
