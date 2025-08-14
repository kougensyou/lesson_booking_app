<script lang="ts" setup>
import { useStudioLessonStore } from '../stores/useStudioLessonStore';
import { useRoute } from 'vue-router';

const route = useRoute();

const studioLessonStore = useStudioLessonStore();

const studioId = route.query.studio_id as string;

studioLessonStore.setDate(new Date());
studioLessonStore.setWeekData();
await studioLessonStore.getStudioLessonData(studioId);
</script>
<template>
  <div class="p-4">
    <!-- ヘッダー -->
    <div class="w-full text-center mb-2">
      <div class="text-xl font-bold">
        {{ studioLessonStore.studioData.studio_name }}
      </div>
    </div>

    <!-- 日付切替 -->
    <template v-if="studioLessonStore.weekData.length > 0">
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
          >
            {{ d.day }}
          </div>
          <div class="text-xs text-gray-500">{{ d.label }}</div>
        </div>
      </div>
    </template>

    <!-- スケジュール表 -->
    <div class="grid grid-cols-7 gap-px text-xs border-t border-l px-2">
      <!-- ヘッダー（日付と曜日） -->
      <div
        v-for="d in studioLessonStore.weekData"
        :key="d.date"
        class="bg-gray-100 text-center py-1"
      >
        <div class="text-sm font-bold">{{ d.date }}</div>
        <div class="text-xs text-gray-500">{{ d.label }}</div>
      </div>
      <div class="col-span-7 text-left text-gray-600 text-sm py-1">7:00</div>
      <div
        v-for="d in studioLessonStore.weekData"
        :key="d.date + '7'"
        class="border-r border-b p-1 align-top h-32"
      >
        <div class="bg-white rounded text-[11px] leading-tight">
          <div class="bg-green-100 font-bold">空き○</div>
          <div>07:00～</div>
          <div class="font-bold">Beginner Flow</div>
          <div class="text-gray-600">Arisa.N</div>
        </div>
      </div>
    </div>
  </div>
</template>
