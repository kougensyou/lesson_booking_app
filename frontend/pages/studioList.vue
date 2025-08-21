<script setup lang="ts">
import { useStudioStore } from '../stores/useStudioStore';

const studioStore = useStudioStore();
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('lessonBooking.tabTitle') }}</title>
    </Head>
  </div>
  <div v-for="(studio, i) in studioStore.studioList" :key="i">
    <NuxtLink
      :to="{
        path: '/studioLesson',
        query: { studio_id: studio.id },
      }"
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
    </NuxtLink>
  </div>
</template>
