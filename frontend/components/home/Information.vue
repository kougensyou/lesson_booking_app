<script setup lang="ts">
import type { Info } from '~/types/information';
import SpinLoading from '../common/SpinLoading.vue';

defineProps<{
  isInformationLoading: boolean;
  sliderInfoList: Array<Info>;
  gridInfoList: Array<Info>;
  listInfoList: Array<Info>;
}>();

const carouselConfig = {
  itemsToShow: 1.0,
  wrapAround: true,
  gap: 10,
  height: 200,
};
</script>
<template>
  <h1 class="text-xl font-bold px-4 pt-4">{{ $t('home.informationTitle') }}</h1>

  <div
    v-if="isInformationLoading"
    class="flex items-center justify-center pt-12 pb-12"
  >
    <SpinLoading />
  </div>

  <template v-if="!isInformationLoading">
    <Carousel v-bind="carouselConfig" class="m-4">
      <Slide v-for="slider in sliderInfoList" :key="slider.id">
        <div
          v-if="slider.image_url && slider.image_path"
          class="w-full h-full rounded-3xl"
        >
          <a :href="slider.link_url" target="_blank" rel="noopener">
            <img
              :src="slider.image_url"
              alt="SliderInfo"
              class="w-full h-full rounded-3xl"
              draggable="false"
            />
          </a>
        </div>
      </Slide>
    </Carousel>
    <div class="p-4 grid grid-cols-2 gap-4">
      <div
        v-for="(grid, index) in gridInfoList"
        :key="index"
        class="rounded-3xl bg-white shadow-md overflow-hidden"
      >
        <img
          v-if="grid.image_url"
          :src="grid.image_url"
          alt=""
          class="w-full h-48 object-cover"
        />
      </div>
    </div>
    <div v-for="item in listInfoList" :key="item.id" class="px-4 py-3 relative">
      <a
        :href="item.link_url"
        target="_blank"
        rel="noopener noreferrer"
        class="text-gray-800"
      >
        {{ item.name }}
      </a>
      <span class="text-gray-400 material-symbols-outlined absolute right-3">
        chevron_right
      </span>
    </div>
  </template>
</template>
