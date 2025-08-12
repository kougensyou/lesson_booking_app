<script setup lang="ts">
import { useLessonBookingStore } from '../stores/useLessonBookingStore';

const lessonBookingStore = useLessonBookingStore();

interface Record {
  date: string;
  time: string;
  title: string;
  place: string;
  teacherName: string;
  teacherImg: string;
  tag1: string;
  tag2: string;
}
interface History {
  yearMonth: string;
  records: Record[];
}
const history: History[] = [
  {
    yearMonth: '2025年8月',
    records: [
      {
        date: '8月5日（火）',
        time: '07:00 – 07:55',
        title: 'Beginner Flow',
        place: '日吉スタジオ',
        teacherName: 'Arisa.N',
        teacherImg: '/arisa.png',
        tag1: 'ピラティス',
        tag2: 'マットグループ',
      },
      {
        date: '8月3日（日）',
        time: '08:15 – 09:10',
        title: 'Beginner Flow',
        place: '日吉スタジオ',
        teacherName: 'Aoi.W',
        teacherImg: '/aoi.png',
        tag1: 'ピラティス',
        tag2: 'マットグループ',
      },
    ],
  },
  {
    yearMonth: '2025年7月',
    records: [
      {
        date: '7月28日（月）',
        time: '18:30 – 19:25',
        title: 'Beginner Flow',
        place: '日吉スタジオ',
        teacherName: 'Lineta',
        teacherImg: '/lineta.png',
        tag1: 'ピラティス',
        tag2: 'マットグループ',
      },
    ],
  },
];
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('lessonBooking.tabTitle') }}</title>
    </Head>
  </div>
  <div class="p-4 space-y-4">
    <div v-for="(item, i) in history" :key="i" class="border-b pb-4">
      <p class="text-gray-500">{{ item.yearMonth }}</p>
      <div
        v-for="(r, j) in item.records"
        :key="j"
        class="mt-2 bg-white rounded-lg p-3 shadow"
      >
        <p class="text-sm text-gray-600">{{ r.date }} {{ r.time }}</p>
        <p class="font-bold">{{ r.title }}</p>
        <p class="text-sm text-gray-600">{{ r.place }}</p>
        <div class="flex items-center mt-1 space-x-2">
          <img :src="r.teacherImg" alt="" class="w-8 h-8 rounded-full" />
          <span>{{ r.teacherName }}</span>
        </div>
        <div class="flex flex-wrap gap-2 mt-2">
          <span class="px-2 py-1 bg-gray-100 rounded">{{ r.tag1 }}</span>
          <span class="px-2 py-1 bg-gray-100 rounded">{{ r.tag2 }}</span>
        </div>
      </div>
    </div>
  </div>
</template>
