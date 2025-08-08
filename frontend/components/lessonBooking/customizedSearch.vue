<script setup lang="ts">
import { Calendar } from 'v-calendar';
import type {
  LessonCategory,
  SearchInputForm,
  Studio,
} from '~/types/lessonBooking';

const props = defineProps<{
  calendarThemeColor: string;
  studioList: Studio[];
  lessonCategoryList: LessonCategory[];
  searchInputForm: SearchInputForm;
  startTimeOptions: string[];
  endTimeOptions: string[];
  searchLessons: Function;
  checkSelected: Function;
  changeByPrev: Function;
  changeByNext: Function;
  removeSelected: Function;
  addSelected: Function;
}>();

onMounted(() => {
  const prev = document.querySelector('.vc-prev');
  const next = document.querySelector('.vc-next');
  prev?.addEventListener('click', async () => {
    await props.changeByPrev();
  });
  next?.addEventListener('click', async () => {
    await props.changeByNext();
  });
});
</script>
<template>
  <h1 class="text-xl font-bold px-4 pt-4">
    {{ $t('lessonBooking.customizedSearch') }}
  </h1>
  <div class="px-4 py-2">
    <Calendar
      class="custom-calendar max-w-full"
      :color="calendarThemeColor"
      expanded
    >
      <template v-slot:day-content="slotProps">
        <div class="flex flex-col h-full z-10 overflow-hidden">
          <span
            v-if="checkSelected(slotProps.day.day)"
            class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-300 text-white m-auto my-1"
            @click="removeSelected(slotProps.day.day)"
          >
            {{ slotProps.day.day }}
          </span>
          <span
            v-else
            class="flex items-center justify-center text-sm w-8 h-8 text-gray-900 m-auto my-1"
            @click="addSelected(slotProps.day.day)"
          >
            {{ slotProps.day.day }}
          </span>
        </div>
      </template>
    </Calendar>
  </div>
  <div class="space-y-2 px-4">
    <span class="text-gray-800 text-sm pt-4">
      {{ $t('lessonBooking.selectTime') }}
    </span>
    <div class="flex items-center space-x-2">
      <select
        v-model="searchInputForm.startTime"
        class="w-1/2 border p-1 rounded"
      >
        <option v-for="time in startTimeOptions" :key="time" :value="time">
          {{ time }}
        </option>
      </select>
      <span class="text-gray-800 text-sm">~</span>
      <select
        v-model="searchInputForm.endTime"
        class="w-1/2 border p-1 rounded"
      >
        <option v-for="time in endTimeOptions" :key="time" :value="time">
          {{ time }}
        </option>
      </select>
    </div>

    <span class="text-gray-800 text-sm pt-4">
      {{ $t('lessonBooking.yogaOrPilates') }}
    </span>
    <select
      class="w-full border p-1 rounded"
      v-model="searchInputForm.yogaOrPilates"
    >
      <option value="">-</option>
      <option
        v-for="category in lessonCategoryList"
        :key="category.id"
        :value="category.id"
      >
        {{ category.category_name }}
      </option>
    </select>

    <span class="text-gray-800 text-sm pt-4">
      {{ $t('lessonBooking.studio') }}
    </span>
    <select class="w-full border p-1 rounded" v-model="searchInputForm.studio">
      <option value="">-</option>
      <option v-for="studio in studioList" :key="studio.id" :value="studio.id">
        {{ studio.studio_name }}
      </option>
    </select>

    <span class="text-gray-800 text-sm pt-4">
      {{ $t('lessonBooking.instructor') }}
    </span>
    <input
      class="w-full border p-1 rounded"
      type="text"
      v-model="searchInputForm.instructor"
    />

    <span class="text-gray-800 text-sm pt-4">
      {{ $t('lessonBooking.lessonName') }}
    </span>
    <input
      class="w-full border p-1 rounded"
      type="text"
      v-model="searchInputForm.lessonName"
    />
  </div>
  <div class="fixed bottom-0 left-0 right-0 bg-white px-4 py-4">
    <div class="max-w-md mx-auto">
      <button
        class="w-full bg-sky-500 text-white rounded-3xl py-4 relative"
        @click="searchLessons"
      >
        <span>{{ $t('lessonBooking.searchButton') }}</span>
        <span
          class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2"
          aria-hidden="true"
        >
          chevron_right
        </span>
      </button>
    </div>
  </div>
</template>
