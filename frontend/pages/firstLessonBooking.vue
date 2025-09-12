<script setup lang="ts">
import { useLessonStore } from '~/stores/useLessonStore';
import { useStudioStore } from '~/stores/useStudioStore';
import { useLessonBookingStore } from '~/stores/useLessonBookingStore';
import FirstSelectedLesson from '~/components/firstLessonBooking/firstSelectedLesson.vue';
import FirstUser from '~/components/firstLessonBooking/firstUser.vue';

definePageMeta({
  layout: 'no-header',
});

const lessonStore = useLessonStore();
const studioStore = useStudioStore();
const lessonBookingStore = useLessonBookingStore();

await studioStore.getStudioList();
await lessonStore.getLessonCategoryList();
</script>
<template>
  <div class="px-4 py-3 space-y-6">
    <FirstSelectedLesson
      :selected-lesson="lessonBookingStore.firstBooking.selectedLesson"
      :studio-list="studioStore.studioList"
      :lesson-category-list="lessonStore.lessonCategoryList"
    />
    <FirstUser :user="lessonBookingStore.firstBooking.user" />
    <button
      class="mt-12 pt-6 pb-6 pl-3 pr-3 bg-sky-500 rounded-3xl w-full relative"
      @click="$router.push('/firstLessonBookingConfirm')"
    >
      <span class="text-white">{{ $t('firstLessonBooking.next') }}</span>
      <span
        class="text-white material-symbols-outlined absolute right-3"
        aria-hidden="true"
      >
        chevron_right
      </span>
    </button>
  </div>
</template>
