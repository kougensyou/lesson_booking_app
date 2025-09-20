<script setup lang="ts">
import { useLessonStore } from '../stores/useLessonStore';
import { useLessonBookingStore } from '../stores/useLessonBookingStore';
import { useRoute, useRouter } from 'vue-router';
import ConfirmDialog from '~/components/lessonDetail/ConfirmDialog.vue';
import ConfirmButton from '~/components/lessonDetail/ConfirmButton.vue';
import SpinLoading from '~/components/common/SpinLoading.vue';
import StatusMessage from '~/components/lessonDetail/StatusMessage.vue';

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

  <div
    v-if="lessonStore.isLessonDetailLoading"
    class="fixed inset-0 flex items-center justify-center"
  >
    <SpinLoading />
  </div>

  <template v-if="!lessonStore.isLessonDetailLoading">
    <StatusMessage
      :done-flag="lessonStore.lessonDetail.done_flag"
      :booked-flag="lessonStore.lessonDetail.booked_flag"
      :empty-flag="lessonStore.lessonDetail.empty_flag"
    />

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
          (lessonStore.lessonDetail.empty_flag ||
            lessonStore.lessonDetail.booked_flag) &&
          !lessonStore.lessonDetail.done_flag
        "
        :open-dialog="lessonBookingStore.openDialog"
        :lesson-detail="lessonStore.lessonDetail"
      />
    </div>
  </template>

  <ConfirmDialog
    v-if="lessonBookingStore.isDialogOpen"
    :is-booking-status-loading="lessonBookingStore.isBookingStatusLoading"
    :lesson-detail="lessonStore.lessonDetail"
    :book-lesson="bookLesson"
    :cancel-lesson="cancelLesson"
    :close-dialog="lessonBookingStore.closeDialog"
  />
</template>
