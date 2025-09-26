<script setup lang="ts">
import { useLessonStore } from '~/stores/useLessonStore';
import { useStudioStore } from '~/stores/useStudioStore';
import { useLessonBookingStore } from '~/stores/useLessonBookingStore';
import { useUserStore } from '~/stores/useUserStore';
import FirstSelectedLesson from '~/components/firstLessonBooking/FirstSelectedLesson.vue';
import FirstUser from '~/components/firstLessonBooking/FirstUser.vue';

definePageMeta({
  layout: 'no-sidebar',
});

const router = useRouter();

const lessonStore = useLessonStore();
const studioStore = useStudioStore();
const lessonBookingStore = useLessonBookingStore();
const userStore = useUserStore();

lessonBookingStore.initializeErrors();
lessonBookingStore.initializeFirstBooking();

const changeStudioLessonData = (selectedDateObj: Date) => {
  lessonStore.setDate(selectedDateObj);
  lessonStore.setWeekData();
  lessonStore.getStudioLessonDataApi().catch((error: any) => {
    useApiErrorHandler(router, error);
  });
};

const validateFirstLesson = () => {
  lessonBookingStore
    .validateFirstLessonApi()
    .then(() => {
      router.push({ path: '/firstLessonBookingConfirm' });
    })
    .catch((error: any) => {
      useApiErrorHandler(router, error);
    });
};

lessonStore.setDate(new Date());
lessonStore.setWeekData();

studioStore.getStudioList().catch((error: any) => {
  useApiErrorHandler(router, error);
});
lessonStore.getLessonCategoryList().catch((error: any) => {
  useApiErrorHandler(router, error);
});
</script>
<template>
  <div class="px-4 py-3 space-y-6">
    <FirstSelectedLesson
      :selected-lesson="lessonBookingStore.firstBooking.selectedLesson"
      :studio-list="studioStore.studioList"
      :studio-lesson-list="lessonStore.studioLessonList"
      :lesson-category-list="lessonStore.lessonCategoryList"
      :set-studio-id="lessonStore.setStudioId"
      :get-studio-lesson-data-api="lessonStore.getStudioLessonDataApi"
      :change-studio-lesson-data="changeStudioLessonData"
      :set-first-selected-lesson="lessonBookingStore.setFirstSelectedLesson"
      :initialize-first-selected-lesson="
        lessonBookingStore.initializeFirstSelectedLesson
      "
      :is-auth="userStore.user.id ? true : false"
      :week-data="lessonStore.weekData"
      :time-options="lessonStore.timeOptions"
      :errors="lessonBookingStore.errors"
    />
    <FirstUser
      :user="lessonBookingStore.firstBooking.user"
      :errors="lessonBookingStore.errors"
    />
    <button
      class="mt-12 bg-sky-500 rounded-3xl w-full py-4 relative"
      @click="validateFirstLesson()"
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
