<script lang="ts" setup>
import type { StudioLesson, WeekData } from '~/types/lesson';
defineProps<{
  isAuth: boolean;
  studioName: string;
  weekData: Array<WeekData>;
  timeOptions: Array<string>;
  studioLessonList: Array<StudioLesson>;
  changeStudioLessonData: Function;
  clickCard: Function;
}>();
</script>
<template>
  <div v-if="isAuth" class="w-full text-center mb-2">
    <div class="text-xl font-bold">
      {{ studioName }}
    </div>
  </div>

  <div class="flex justify-between px-4 mb-2">
    <div
      v-for="d in weekData"
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
      v-for="d in weekData"
      :key="d.date"
      class="bg-gray-100 text-center py-1"
    >
      <div class="text-sm font-bold">{{ d.date }}</div>
      <div class="text-xs text-gray-500">{{ d.label }}</div>
    </div>

    <template v-for="time in timeOptions">
      <div class="col-span-7 text-left text-gray-600 text-sm py-1">
        {{ time }}
      </div>

      <div
        v-for="d in weekData"
        :key="d.date"
        class="border-r border-b p-1 align-top h-32"
      >
        <template v-for="studioLesson in studioLessonList?.[d.date]?.[time]">
          <div
            class="bg-white rounded text-[11px] leading-tight"
            @click="clickCard(studioLesson)"
          >
            <div v-if="isAuth" class="bg-green-100 font-bold">空き○</div>
            <div>{{ studioLesson.start_time }} ～</div>
            <div class="font-bold">{{ studioLesson.lesson_name }}</div>
            <div v-if="isAuth" class="text-gray-600">
              {{ studioLesson.instructor_name }}
            </div>
          </div>
        </template>
      </div>
    </template>
  </div>
</template>
