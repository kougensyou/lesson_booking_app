<script setup lang="ts">
import { onMounted } from 'vue';
import { useHomeStore } from '../stores/useHomeStore';
import HorizontalScroll from '../components/horizontalScroll.vue';
import { Calendar } from 'v-calendar';
//import { useRouter } from 'vue-router';

//const router = useRouter();
const homeStore = useHomeStore();
const attributes = computed(() =>
  homeStore.selectedLessonList.map((lesson, idx) => ({
    key: idx,
    dates: new Date(lesson.lesson_date),
    customData: {
      done_flag: lesson.done_flag,
    },
  }))
);

onMounted(() => {
  const prev = document.querySelector('.vc-prev');
  const next = document.querySelector('.vc-next');
  prev?.addEventListener('click', async () => {
    await homeStore.getPrevLessonList();
  });
  next?.addEventListener('click', async () => {
    await homeStore.getNextLessonList();
  });
});

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
  <div class="px-4">
    <Calendar
      class="custom-calendar max-w-full"
      :color="homeStore.calendarThemeColor"
      :attributes="attributes"
      expanded
    >
      <template v-slot:day-content="slotProps">
        <div class="flex flex-col h-full z-10 overflow-hidden">
          <span class="day-label text-sm text-gray-900">{{
            slotProps.day.day
          }}</span>
          <p
            v-for="attr in slotProps.attributes"
            :key="attr.key"
            class="text-xs leading-tight rounded-sm p-1 mt-0 mb-1"
          >
            <span v-if="attr.customData.done_flag"
              ><p class="w-8 h-8 rounded-full bg-green-600"></p
            ></span>
            <span v-else
              ><p class="w-8 h-8 rounded-full bg-green-100"></p
            ></span>
          </p>
        </div>
      </template>
    </Calendar>
  </div>
</template>
