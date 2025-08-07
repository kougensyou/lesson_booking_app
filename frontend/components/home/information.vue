<script setup lang="ts">
import type { Info } from '~/types/home';
import HorizontalScroll from '.././horizontalScroll.vue';

defineProps<{
  sliderInfoList: Array<Info>;
  gridInfoList: Array<Info>;
  listInfoList: Array<Info>;
}>();
</script>
<template>
  <h1 class="text-xl font-bold px-4 pt-4">{{ $t('home.informationTitle') }}</h1>
  <HorizontalScroll>
    <div
      v-for="slider in sliderInfoList"
      :key="slider.id"
      class="min-w-full h-[200px] bg-white rounded-xl shadow-md flex flex-col justify-between"
    >
      <a :href="slider.link_url" target="_blank" rel="noopener">
        <img
          v-if="slider.image_url"
          :src="slider.image_url"
          alt="SliderInfo"
          class="w-full h-full object-cover"
          draggable="false"
        />
      </a>
    </div>
  </HorizontalScroll>
  <div class="p-4 grid grid-cols-2 gap-4">
    <div
      v-for="(grid, index) in gridInfoList"
      :key="index"
      class="rounded-xl shadow-md overflow-hidden"
    >
      <img
        v-if="grid.image_url"
        :src="grid.image_url"
        alt=""
        class="w-full h-48 object-cover"
      />
    </div>
  </div>
  <div
    v-for="item in listInfoList"
    :key="item.id"
    class="px-4 py-3 border-b border-gray-100 relative"
  >
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
