<script lang="ts" setup>
import { useStudioLessonStore } from '../stores/useStudioLessonStore';
import { useRoute } from 'vue-router';

const route = useRoute();

const studioLessonStore = useStudioLessonStore();

const studioId = route.query.studio_id as string;

const changeStudioLessonData = (selectedDateObj: Date) => {
  studioLessonStore.setDate(selectedDateObj);
  studioLessonStore.setWeekData();
  studioLessonStore.getStudioLessonDataApi();
};

studioLessonStore.setStudioId(studioId);
studioLessonStore.setDate(new Date());
studioLessonStore.setWeekData();
await studioLessonStore.getStudioLessonDataApi();
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('lessonBooking.tabTitle') }}</title>
    </Head>
  </div>
  <div class="p-4">
    <div class="w-full text-center mb-2">
      <div class="text-xl font-bold">
        {{ studioLessonStore.studioData.studio_name }}
      </div>
    </div>
    <div class="flex justify-between px-4 mb-2">
      <div
        v-for="d in studioLessonStore.weekData"
        :key="d.date"
        class="flex flex-col items-center w-12"
      >
        <div
          :class="[
            'w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold',
            d.active ? 'bg-black text-white' : 'bg-white text-black border',
          ]"
          @click="!d.active ? changeStudioLessonData(d.dateObj) : null"
        >
          {{ d.day }}
        </div>
        <div class="text-xs text-gray-500">{{ d.label }}</div>
      </div>
    </div>

    <div class="grid grid-cols-7 gap-px text-xs border-t border-l px-2">
      <div
        v-for="d in studioLessonStore.weekData"
        :key="d.date"
        class="bg-gray-100 text-center py-1"
      >
        <div class="text-sm font-bold">{{ d.date }}</div>
        <div class="text-xs text-gray-500">{{ d.label }}</div>
      </div>

      <template v-for="time in studioLessonStore.timeOptions">
        <div class="col-span-7 text-left text-gray-600 text-sm py-1">
          {{ time }}
        </div>

        <div
          v-for="d in studioLessonStore.weekData"
          :key="d.date"
          class="border-r border-b p-1 align-top h-32"
        >
          <template
            v-for="studioLesson in studioLessonStore.studioLessonList?.[
              d.date
            ]?.[time]"
          >
            <div
              class="bg-white rounded text-[11px] leading-tight"
              @click="
                $router.push({
                  path: '/lessonDetail',
                  query: { lesson_id: studioLesson.lesson_id },
                })
              "
            >
              <div class="bg-green-100 font-bold">空き○</div>
              <div>{{ studioLesson.startTime }} ～</div>
              <div class="font-bold">{{ studioLesson.lessonName }}</div>
              <div class="text-gray-600">{{ studioLesson.instructorName }}</div>
            </div>
          </template>
        </div>
      </template>
    </div>
  </div>
</template>
