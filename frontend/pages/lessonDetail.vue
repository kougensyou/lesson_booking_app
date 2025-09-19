<script setup lang="ts">
import { useLessonStore } from '../stores/useLessonStore';
import { useLessonBookingStore } from '../stores/useLessonBookingStore';
import ConfirmDialog from '~/components/lessonDetail/ConfirmDialog.vue';
import ConfirmButton from '~/components/lessonDetail/ConfirmButton.vue';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();

const bookLesson = () => {
  lessonBookingStore.bookLessonApi(lessonStore.lessonId).then(() => {
    router.push({ path: '/bookDone' });
  });
};

const cancelLesson = () => {
  lessonBookingStore.cancelLessonApi(lessonStore.lessonId).then(() => {
    router.push({ path: '/cancelDone' });
  });
};

const lessonStore = useLessonStore();
const lessonBookingStore = useLessonBookingStore();

const lessonId = route.query.lesson_id as string;

lessonStore.setLessonId(lessonId);
lessonStore.getLessonDetailApi();
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('lessonDetail.tabTitle') }}</title>
    </Head>
  </div>
  <p
    v-if="
      lessonStore.lessonDetail.done_flag &&
      lessonStore.lessonDetail.reserved_flag
    "
    class="text-center mb-2 bg-gray-100 px-4 py-6 rounded"
  >
    {{ $t('lessonDetail.doneMessage') }}
  </p>
  <p
    v-if="
      !lessonStore.lessonDetail.done_flag &&
      lessonStore.lessonDetail.reserved_flag
    "
    class="text-center mb-2 bg-gray-100 px-4 py-6 rounded"
  >
    {{ $t('lessonDetail.bookingMessage') }}
  </p>
  <div class="bg-white min-h-screen p-4 space-y-4 max-w-xl mx-auto">
    <h1 class="text-xl font-bold">
      {{ lessonStore.lessonDetail.lesson_name }}
    </h1>
    <div class="flex items-center text-gray-600 text-sm">
      <span class="material-symbols-outlined"> person </span>
      {{ lessonStore.lessonDetail.instructor_name }}
    </div>
    <div class="flex text-sm text-gray-700">
      <span>{{ lessonStore.lessonDetail.studio_name }}</span>
      <span class="ml-auto">{{
        lessonStore.lessonDetail.lesson_datetime
      }}</span>
    </div>

    <img
      :src="lessonStore.lessonDetail.lesson_image_url"
      alt="Lesson"
      class="w-full rounded"
    />

    <div class="text-sm space-y-2 leading-relaxed">
      {{ lessonStore.lessonDetail.lesson_explanation }}
    </div>

    <div class="flex items-center space-x-4 mt-4">
      <img
        :src="lessonStore.lessonDetail.instructor_image_url"
        alt="Instructor"
        class="w-14 h-14 rounded-full object-cover"
      />
      <div class="font-semibold">
        {{ lessonStore.lessonDetail.instructor_name }}
      </div>
    </div>
    <div class="text-sm text-gray-500">
      {{ lessonStore.lessonDetail.instructor_introduction }}
    </div>

    <ConfirmButton
      v-if="
        !lessonStore.lessonDetail.done_flag ||
        !lessonStore.lessonDetail.reserved_flag
      "
      :open-dialog="lessonBookingStore.openDialog"
      :lesson-detail="lessonStore.lessonDetail"
    />
  </div>

  <ConfirmDialog
    v-if="lessonBookingStore.isDialogOpen"
    :lesson-detail="lessonStore.lessonDetail"
    :book-lesson="bookLesson"
    :cancel-lesson="cancelLesson"
    :close-dialog="lessonBookingStore.closeDialog"
  />
</template>
