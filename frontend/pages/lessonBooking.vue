<script setup lang="ts">
import { onMounted } from 'vue';
import { useLessonBookingStore } from '../stores/useLessonBookingStore';
import HorizontalScroll from '../components/horizontalScroll.vue';
import { Calendar } from 'v-calendar';
//import { useRouter } from 'vue-router';

//const router = useRouter();
const lessonBookingStore = useLessonBookingStore();

await lessonBookingStore.getLessonBookingData();
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('lessonBooking.tabTitle') }}</title>
    </Head>
  </div>
  <h1 class="text-xl font-bold px-4 pt-4">
    {{ $t('lessonBooking.searchFromStudio') }}
  </h1>
  <template v-if="lessonBookingStore.favoriteStudioList.length === 0">
    <button
      class="mt-6 pt-6 pb-6 px-8 bg-sky-500 rounded-3xl mx-auto block"
      @click=""
    >
      <span class="text-white">{{ $t('home.reserveLesson') }}</span>
    </button>
  </template>
  <template v-if="lessonBookingStore.favoriteStudioList.length > 0">
    <HorizontalScroll>
      <div
        v-for="favoriteStudio in lessonBookingStore.favoriteStudioList"
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
    </HorizontalScroll>
  </template>
</template>
