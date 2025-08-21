<script setup lang="ts">
import { useLessonStore } from '../stores/useLessonStore';
import LessonList from '../components/common/lessonList.vue';
const lessonStore = useLessonStore();

await lessonStore.getSameStudioLessonList(lessonStore.lessonDetail.studio_id);
</script>
<template>
  <div class="p-4">
    <h2 class="text-xl font-bold text-center mb-4">
      {{ $t('bookDone.doneMessage') }}
    </h2>

    <div class="bg-white shadow-md rounded-lg p-4 mb-4">
      <div class="text-center text-sm text-gray-500">
        {{ lessonStore.lessonDetail.studio_name }}
      </div>
      <div class="text-center text-2xl font-semibold my-2">
        {{ lessonStore.lessonDetail.lesson_datetime }}
      </div>

      <div class="flex items-start space-x-2 mt-4">
        <img
          :src="lessonStore.lessonDetail.instructor_image_url"
          alt="Instructor"
          class="rounded-full w-10 h-10"
        />
        <div
          style="white-space: pre-line"
          class="bg-gray-100 rounded-md p-2 text-sm"
        >
          <!-- {{ bookDoneStore.instructorMessage }} -->
        </div>
      </div>
    </div>

    <button
      class="w-full bg-orange-500 text-white py-2 rounded-md font-semibold hover:bg-orange-600"
      @click="
        $router.push({
          path: '/lessonBooking',
        })
      "
    >
      {{ $t('bookDone.continueBookingButton') }}
    </button>

    <div class="mt-6">
      <h3 class="font-semibold mb-2">
        {{ $t('bookDone.recommended') }}
      </h3>

      <LessonList :lesson-list="lessonStore.sameStudioLessonList" />
    </div>
  </div>
</template>
