<script setup lang="ts">
import { Calendar } from 'v-calendar';

defineProps<{
  calendarThemeColor: string;
}>();
</script>
<template>
  <h1 class="text-xl font-bold px-4 pt-4">
    {{ $t('lessonBooking.customizedSearch') }}
  </h1>
  <div class="px-4 py-2">
    <Calendar
      class="custom-calendar max-w-full"
      :color="calendarThemeColor"
      :attributes="attributes"
      expanded
    >
      <template v-slot:day-content="slotProps">
        <div class="flex flex-col h-full z-10 overflow-hidden">
          <span>
            {{ slotProps.day.day }}
          </span>
          <template>
            <span
              class="flex items-center justify-center w-full h-full mt-1 mb-1"
            >
              <span class="w-8 h-8 rounded-full transparent m-auto my-1"></span>
            </span>
          </template>
        </div>
      </template>
    </Calendar>
  </div>
  <div class="space-y-2">
    <span class="text-gray-800 text-sm px-4 pt-4">
      {{ $t('lessonBooking.selectTime') }}
    </span>
    <div class="flex space-x-2">
      <select v-model="startTime" class="w-1/2 border p-1 rounded">
        <option v-for="time in timeOptions" :key="time" :value="time">
          {{ time }}から
        </option>
      </select>
      <select v-model="endTime" class="w-1/2 border p-1 rounded">
        <option v-for="time in timeOptions" :key="time" :value="time">
          {{ time }}まで
        </option>
      </select>
    </div>

    <span class="text-gray-800 text-sm px-4 pt-4">
      {{ $t('lessonBooking.yogaOrPilates') }}
    </span>
    <select class="w-full border p-1 rounded">
      <option>-</option>
    </select>

    <span class="text-gray-800 text-sm px-4 pt-4">
      {{ $t('lessonBooking.studio') }}
    </span>
    <select class="w-full border p-1 rounded">
      <option>-</option>
    </select>

    <span class="text-gray-800 text-sm px-4 pt-4">
      {{ $t('lessonBooking.instructor') }}
    </span>
    <select class="w-full border p-1 rounded">
      <option>-</option>
    </select>

    <span class="text-gray-800 text-sm px-4 pt-4">
      {{ $t('lessonBooking.lessonName') }}
    </span>
    <select class="w-full border p-1 rounded">
      <option>-</option>
    </select>

    <button
      class="mt-12 pt-6 pb-6 pl-3 pr-3 bg-sky-500 rounded-3xl w-full relative"
      @click=""
    >
      <span class="text-white">{{ $t('lessonBooking.searchButton') }}</span>
      <span
        class="text-white material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2"
        aria-hidden="true"
      >
        chevron_right
      </span>
    </button>
  </div>
</template>
