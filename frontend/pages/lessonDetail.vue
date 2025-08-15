<script setup lang="ts">
import { useLessonDetailStore } from '../stores/useLessonDetailStore';
import { useRoute } from 'vue-router';

const route = useRoute();

const lessonDetailStore = useLessonDetailStore();

const lessonId = route.query.lesson_id as string;

lessonDetailStore.setLessonId(lessonId);
await lessonDetailStore.getLessonDetailApi();
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('lessonDetail.tabTitle') }}</title>
    </Head>
  </div>
  <div class="bg-white min-h-screen p-4 space-y-4 max-w-xl mx-auto">
    <h1 class="text-xl font-bold">
      {{ lessonDetailStore.lessonDetail.lesson_name }}
    </h1>
    <div class="flex items-center text-gray-600 text-sm">
      <span class="material-symbols-outlined"> person </span>
      {{ lessonDetailStore.lessonDetail.instructor_name }}
    </div>
    <div class="flex text-sm text-gray-700">
      <span>{{ lessonDetailStore.lessonDetail.studio_name }}</span>
      <span class="ml-auto">{{
        lessonDetailStore.lessonDetail.lesson_time
      }}</span>
    </div>

    <img
      :src="lessonDetailStore.lessonDetail.lesson_image_url"
      alt="Lesson"
      class="w-full rounded"
    />

    <div class="text-sm space-y-2 leading-relaxed">
      {{ lessonDetailStore.lessonDetail.lesson_explanation }}
    </div>

    <div class="flex items-center space-x-4 mt-4">
      <img
        :src="lessonDetailStore.lessonDetail.instructor_image_url"
        alt="Instructor"
        class="w-14 h-14 rounded-full object-cover"
      />
      <div class="font-semibold">
        {{ lessonDetailStore.lessonDetail.instructor_name }}
      </div>
    </div>
    <div class="text-sm text-gray-500">
      {{ lessonDetailStore.lessonDetail.instructor_introduction }}
    </div>

    <div class="fixed bottom-0 left-0 right-0 bg-white p-8">
      <div class="max-w-md mx-auto space-y-4">
        <button
          class="w-full bg-sky-500 text-white rounded-3xl py-4 relative"
          @click="lessonDetailStore.openDialog"
        >
          <span>{{ $t('lessonDetail.bookButton') }}</span>
        </button>
        <div
          class="text-center text-sm text-blue-600 underline cursor-pointer"
          @click="$router.back()"
        >
          {{ $t('lessonDetail.backButton') }}
        </div>
      </div>
    </div>
  </div>
  <template v-if="lessonDetailStore.isDialogOpen">
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50"></div>
    <div
      class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
    >
      <div class="bg-white rounded-lg shadow-lg w-[80%] max-w-md p-6">
        <h2 class="text-lg font-semibold mb-4 text-center">
          以下のレッスンを予約確定しますか？
        </h2>

        <div class="border rounded-md p-4 flex items-start mb-6">
          <div class="text-center w-24 flex-shrink-0">
            <div class="text-sm font-semibold">札幌</div>
            <div class="text-lg font-bold mt-1">08/25</div>
            <div class="text-sm">10:45 - 11:40</div>
          </div>
          <div class="ml-4 flex-1">
            <div class="font-semibold text-base mb-1">
              骨盤底筋ピラティス〜ポッコリお腹を改善〜
            </div>
            <div class="text-sm text-gray-600 flex items-center space-x-2">
              <span class="font-medium">Kei</span>
            </div>
          </div>
        </div>
        <div
          class="flex flex-col space-y-3 sm:flex-row sm:space-y-0 sm:space-x-4"
        >
          <button
            class="flex-1 bg-orange-500 hover:bg-orange-600 text-white py-2 rounded font-semibold"
            @click="lessonDetailStore.bookLesson"
          >
            予約を確定
          </button>
          <button
            class="flex-1 border border-gray-300 text-gray-700 py-2 rounded"
            @click="lessonDetailStore.closeDialog"
          >
            戻る
          </button>
        </div>
      </div>
    </div>
  </template>
</template>
