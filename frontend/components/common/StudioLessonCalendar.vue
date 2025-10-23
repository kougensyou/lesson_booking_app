<script lang="ts" setup>
import type { StudioLesson, WeekData } from '~/types/lesson';
import SpinLoading from './SpinLoading.vue';

defineProps<{
  vacantMessage: string;
  noVacantMessage: string;
  isAuth: boolean;
  isLoading: boolean;
  studioName: string;
  weekData: WeekData[];
  totalWeekData: Array<Array<WeekData>>;
  activeDate: string;
  timeOptions: Array<string>;
  studioLessonList: Array<StudioLesson>;
  changeStudioLessonData: Function;
  clickCard: Function;
}>();

const carouselConfig = {
  itemsToShow: 1.0,
  height: 50,
};
</script>
<template>
  <div v-if="isAuth" class="w-full text-center p-4 bg-white">
    <div class="text-xl font-bold">
      {{ studioName }}
    </div>
  </div>

  <div
    class="px-4 py-3 mb-2"
    style="background-image: url('/studio-template.png')"
  >
    <Carousel v-bind="carouselConfig">
      <Slide v-for="(oneWeekData, i) in totalWeekData" :key="i">
        <div class="grid grid-cols-7 w-full">
          <div
            v-for="d in oneWeekData"
            :key="d.date"
            class="flex flex-col items-center"
          >
            <div
              class="w-8 h-8 flex items-center justify-center rounded-full cursor-pointer"
              :class="
                activeDate === d.date ? 'bg-black text-white' : 'text-white'
              "
              @click="
                !(activeDate === d.date)
                  ? changeStudioLessonData(d.date_obj, d.date)
                  : null
              "
            >
              {{ d.day }}
            </div>
            <div class="text-xs text-white mt-1">{{ d.label }}</div>
          </div>
        </div>
      </Slide>
    </Carousel>
  </div>

  <div class="grid grid-cols-7 gap-px text-xs border-t border-l px-2">
    <div
      v-for="d in weekData"
      :key="d.date"
      class="bg-gray-100 text-center py-2 sticky top-0 z-10"
    >
      <div class="text-sm font-bold">{{ d.date }}</div>
      <div class="text-xs text-gray-500">{{ d.label }}</div>
    </div>

    <div
      v-if="isLoading"
      class="fixed inset-0 flex items-center justify-center"
    >
      <SpinLoading />
    </div>

    <template v-for="time in timeOptions">
      <div class="col-span-7 text-left text-gray-600 text-sm py-1">
        {{ time }}
      </div>

      <div
        v-for="d in weekData"
        :key="d.date"
        class="border-r border-b p-1 align-top bg-indigo-50 min-h-32"
      >
        <template v-for="studioLesson in studioLessonList?.[d.date]?.[time]">
          <div
            class="bg-white rounded text-center"
            @click="clickCard(studioLesson)"
          >
            <div
              v-if="isAuth && studioLesson.empty_flag"
              class="bg-green-200 font-bold p-1 text-[11px]"
            >
              {{ vacantMessage }}
            </div>
            <div
              v-if="isAuth && !studioLesson.empty_flag"
              class="bg-red-200 font-bold p-1 text-[11px]"
            >
              {{ noVacantMessage }}
            </div>
            <div class="p-1 text-[11px]">{{ studioLesson.start_time }} ～</div>
            <div class="font-bold p-1 text-[14px] break-words">
              {{ studioLesson.lesson_name }}
            </div>
            <div v-if="isAuth" class="text-gray-600">
              {{ studioLesson.instructor_name }}
            </div>
          </div>
        </template>
      </div>
    </template>
  </div>
</template>
