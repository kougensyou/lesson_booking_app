<script setup lang="ts">
import { useLessonDetailStore } from '../stores/useLessonDetailStore';
import ConfirmDialog from '~/components/lessonDetail/confirmDialog.vue';
import ConfirmButton from '~/components/lessonDetail/confirmButton.vue';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();

const bookLesson = () => {
  lessonDetailStore.bookLessonApi().then(() => {
    router.push({ path: '/bookDone' });
  });
};

const cancelLesson = () => {
  lessonDetailStore.cancelLessonApi().then(() => {
    router.push({ path: '/bookDone' });
  });
};

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
        lessonDetailStore.lessonDetail.lesson_datetime
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

    <ConfirmButton
      :open-dialog="lessonDetailStore.openDialog"
      :lesson-detail="lessonDetailStore.lessonDetail"
    />
  </div>
  <template v-if="lessonDetailStore.isDialogOpen">
    <ConfirmDialog
      :lesson-detail="lessonDetailStore.lessonDetail"
      :book-lesson="bookLesson"
      :cancel-lesson="cancelLesson"
      :close-dialog="lessonDetailStore.closeDialog"
    />
  </template>
</template>
