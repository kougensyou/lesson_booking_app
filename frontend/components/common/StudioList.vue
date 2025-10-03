<script setup lang="ts">
import type { Studio } from '~/types/lesson';

defineProps<{
  studioList: Array<Studio>;
  clickStudioCard: Function;
}>();
</script>
<template>
  <div
    v-for="(studio, i) in studioList"
    :key="i"
    :class="[
      'pr-4 pl-4',
      i === 0 || i === studioList.length - 1 ? 'pt-4 pb-4' : 'pt-2 pb-2',
    ]"
  >
    <div
      @click="clickStudioCard(studio)"
      class="min-w-[300px] h-[200px] bg-white rounded-3xl shadow-md flex flex-col justify-between"
    >
      <img
        :src="studio.image_url"
        alt=""
        class="w-full h-40 object-cover rounded-t-3xl"
      />
      <div class="p-2">
        <h3 class="text-base font-semibold">
          {{ studio.studio_name }}
        </h3>
      </div>
    </div>
  </div>
</template>
