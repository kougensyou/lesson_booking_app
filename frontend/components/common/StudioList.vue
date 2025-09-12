<script setup lang="ts">
import type { Studio } from '~/types/lesson';

defineProps<{
  studioList: Array<Studio>;
  clickStudioCard: Function;
}>();
</script>
<template>
  <div v-for="(studio, i) in studioList" :key="i">
    <div
      @click="clickStudioCard(studio)"
      class="min-w-[300px] h-[200px] bg-white rounded-xl shadow-md flex flex-col justify-between p-8"
    >
      <img
        :src="studio.image_url"
        alt=""
        class="w-full h-32 object-cover rounded-t-lg"
      />
      <div class="p-3">
        <h3 class="text-base font-semibold">
          {{ studio.studio_name }}
        </h3>
      </div>
    </div>
  </div>
</template>
