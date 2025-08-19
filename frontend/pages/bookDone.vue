<script setup lang="ts">
import { useLessonDetailStore } from '../stores/useLessonDetailStore';
import { useBookDoneStore } from '../stores/useBookDoneStore';
const lessonDetailStore = useLessonDetailStore();
const bookDoneStore = useBookDoneStore();
</script>
<template>
  <div class="p-4">
    <h2 class="text-xl font-bold text-center mb-4">
      {{ $t('bookDone.doneMessage') }}
    </h2>

    <div class="bg-white shadow-md rounded-lg p-4 mb-4">
      <div class="text-center text-sm text-gray-500">
        {{ lessonDetailStore.lessonDetail.studio_name }}
      </div>
      <div class="text-center text-2xl font-semibold my-2">
        {{ lessonDetailStore.lessonDetail.lesson_datetime }}
      </div>

      <div class="flex items-start space-x-2 mt-4">
        <img
          :src="lessonDetailStore.lessonDetail.instructor_image_url"
          alt="Instructor"
          class="rounded-full w-10 h-10"
        />
        <div
          style="white-space: pre-line"
          class="bg-gray-100 rounded-md p-2 text-sm"
        >
          {{ bookDoneStore.instructorMessage }}
        </div>
      </div>
    </div>

    <button
      class="w-full bg-orange-500 text-white py-2 rounded-md font-semibold hover:bg-orange-600"
    >
      {{ $t('bookDone.continueBookingButton') }}
    </button>

    <div class="mt-6">
      <h3 class="font-semibold mb-2">予約したレッスンと似ている</h3>

      <div class="bg-white border p-4 rounded-lg shadow-sm">
        <div class="flex justify-between text-sm text-gray-600">
          <span>綱島</span>
          <span>08/20（水）20:00 - 20:55</span>
        </div>
        <div class="mt-1 text-blue-600 text-xs">空き〇</div>
        <div class="mt-2 text-sm">
          <span
            class="bg-blue-200 text-blue-800 px-2 py-0.5 rounded text-xs mr-1"
            >グループ ALL</span
          >
          マジックサークル〜コアを安定させる〜
        </div>
        <div class="text-xs text-gray-500 mt-1">講師: Sam</div>
      </div>
    </div>
  </div>
</template>
