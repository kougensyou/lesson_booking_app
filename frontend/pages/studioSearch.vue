<template>
  <div class="p-4">
    <!-- タブ -->
    <div class="flex border-b">
      <button
        class="flex-1 py-2 text-center border-b-2 border-sky-500 text-sky-500"
      >
        名前から
      </button>
      <button class="flex-1 py-2 text-center text-gray-500">マップから</button>
    </div>

    <!-- 検索バー -->
    <div class="flex items-center mt-4 bg-gray-100 rounded px-3 py-2">
      <span class="text-gray-400">🔍</span>
      <input
        type="text"
        placeholder="スタジオ名検索"
        class="flex-1 bg-transparent outline-none ml-2"
      />
    </div>

    <!-- リスト -->
    <div v-for="(group, i) in studios" :key="i" class="mt-6">
      <p class="text-gray-500 mb-2">{{ group.initial }}</p>
      <div
        v-for="(studio, j) in group.items"
        :key="j"
        class="flex items-center mb-3"
      >
        <span class="flex-1">{{ studio.name }}</span>
        <span
          class="px-3 py-1 border rounded-full text-sm"
          :class="
            studio.type === 'ピラティス'
              ? 'border-sky-500 text-sky-500'
              : 'border-green-500 text-green-500'
          "
        >
          {{ studio.type }}{{ studio.num }}
        </span>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
interface Studio {
  name: string;
  type: string;
  num: string;
}
interface StudioGroup {
  initial: string;
  items: Studio[];
}
const studios: StudioGroup[] = [
  {
    initial: 'み',
    items: [
      { name: '溝の口', type: 'ピラティス', num: '01' },
      { name: '三田', type: 'ピラティス', num: '01' },
      { name: '南森町', type: 'ピラティス', num: '02' },
      { name: '茗荷谷', type: 'ピラティス', num: '01' },
      { name: '茗荷谷', type: 'ヨガ', num: '02' },
    ],
  },
  {
    initial: 'む',
    items: [
      { name: '武蔵小杉', type: 'ピラティス', num: '01' },
      { name: '武蔵小山', type: 'ピラティス', num: '01' },
    ],
  },
];
</script>
