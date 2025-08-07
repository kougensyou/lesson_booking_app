<script lang="ts" setup>
const days = [
  { date: '08/19', day: '19', label: '火', active: true },
  { date: '08/20', day: '20', label: '水', active: false },
  { date: '08/21', day: '21', label: '木', active: false },
  { date: '08/22', day: '22', label: '金', active: false },
  { date: '08/23', day: '23', label: '土', active: false },
  { date: '08/24', day: '24', label: '日', active: false },
  { date: '08/25', day: '25', label: '月', active: false },
];

const hours = ['7:00', '8:00', '9:00'];

const hasClass = (date: string, hour: string) => {
  return date === '08/19' && hour === '7:00';
};
</script>
<template>
  <div class="p-4">
    <!-- ヘッダー -->
    <div class="w-full text-center mb-2">
      <div class="text-xl font-bold">日吉</div>
      <div class="text-sm text-gray-500">pilates</div>
    </div>

    <!-- 日付切替 -->
    <div class="flex justify-between px-4 mb-2">
      <div
        v-for="d in days"
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

    <!-- スケジュール表 -->
    <div class="grid grid-cols-7 gap-px text-xs border-t border-l px-2">
      <!-- ヘッダー（日付と曜日） -->
      <div v-for="d in days" :key="d.date" class="bg-gray-100 text-center py-1">
        <div class="text-sm font-bold">{{ d.date }}</div>
        <div class="text-xs text-gray-500">{{ d.label }}</div>
      </div>

      <!-- 7:00行 -->
      <div
        v-for="d in days"
        :key="d.date + '7'"
        class="border-r border-b p-1 align-top h-32"
      >
        <div
          v-if="hasClass(d.date, '7:00')"
          class="bg-green-100 p-1 rounded text-[11px] leading-tight"
        >
          <div class="text-[11px] text-gray-600 mb-1">7:00</div>
          <!-- ←時間表示を上に -->
          <div class="text-green-700 font-bold">空き○</div>
          <div>07:00～</div>
          <div>オンラインあり</div>
          <div class="font-bold">Beginner Flow</div>
          <div class="text-gray-600">Arisa.N</div>
        </div>
      </div>
    </div>
  </div>
</template>
