<script setup lang="ts">
import { ref } from 'vue'

interface Studio {
  id: number
  name: string
  image: string
  program: string
  favorite: boolean
}

const studios = ref<Studio[]>([
  { id: 1, name: '日吉', image: '/hiyoshi.jpg', program: 'ピラティス01', favorite: true },
  { id: 2, name: '自由が丘 第1', image: '/jiyugaoka.jpg', program: 'ピラティス01', favorite: true }
])
</script>

<template>
  <div class="p-4">
    <h1 class="text-lg font-bold text-center mb-4">{{ $t('favoriteStudio.pageTitle') }}</h1>

    <div v-for="studio in studios" :key="studio.id" class="flex items-center mb-3">
      <img :src="studio.image" class="w-24 h-16 rounded-lg object-cover mr-3" />
      <div class="flex-1">
        <div class="flex items-center">
          <span class="font-semibold">{{ studio.name }}</span>
          <span class="ml-1 text-red-500">❤</span>
        </div>
        <span class="text-sm border rounded-full px-2 py-0.5 text-blue-600">
          {{ studio.program }}
        </span>
      </div>
      <button class="ml-2 text-red-400 text-xl">－</button>
    </div>

    <div class="border-2 border-dashed rounded-lg py-4 text-center text-gray-500 mb-4">
        {{ $t('favoriteStudio.searchStudio') }}
    </div>

    <button class="w-full py-2 rounded-2xl bg-blue-100 text-blue-600 font-semibold">
        {{ $t('favoriteStudio.save') }}
    </button>
  </div>
</template>