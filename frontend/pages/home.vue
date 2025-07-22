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
        class="min-w-[300px] h-[200px] bg-blue-100 rounded-xl shadow flex items-center justify-center shrink-0"
      >
        カード {{ lesson.lesson_name }}
      </div>
    </HorizontalScroll>
  </template>
</template>
