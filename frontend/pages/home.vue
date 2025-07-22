<script setup lang="ts">
import { useHomeStore } from '../stores/useHomeStore';
import HorizontalScroll from '../components/horizontalScroll.vue';
//import { useRouter } from 'vue-router';

//const router = useRouter();
const homeStore = useHomeStore();

await homeStore.getHomeData();
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('home.tabTitle') }}</title>
    </Head>
  </div>
  <template v-if="homeStore.nextLessonList.length > 0">
    <HorizontalScroll>
      <div
        v-for="lesson in homeStore.nextLessonList"
        :key="lesson.id"
        class="min-w-[300px] h-[200px] bg-white rounded-xl shadow-md flex flex-col justify-between p-8"
      >
        <div>
          <div class="text-md text-gray-500">{{ lesson.lesson_time }}</div>
          <div class="text-lg font-bold mt-1">{{ lesson.lesson_name }}</div>
        </div>
        <div>
          <div class="text-md text-gray-600 mt-2">{{ lesson.studio_name }}</div>
          <div class="flex items-center mt-2">
            <img
              :src="lesson.image_url"
              alt="Instructor"
              class="w-8 h-8 rounded-full mr-2"
            />
            <div class="text-md text-gray-800">
              {{ lesson.instructor_name }}
            </div>
          </div>
        </div>
      </div>
    </HorizontalScroll>
  </template>
</template>
