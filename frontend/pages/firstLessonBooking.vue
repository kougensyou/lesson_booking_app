<script setup lang="ts">
import { useLessonStore } from '~/stores/useLessonStore';
import { useStudioStore } from '~/stores/useStudioStore';
import { useLessonBookingStore } from '~/stores/useLessonBookingStore';
import { useUserStore } from '~/stores/useUserStore';
import { onMounted } from 'vue';
import FirstSelectedLesson from '~/components/firstLessonBooking/FirstSelectedLesson.vue';
import FirstUser from '~/components/firstLessonBooking/FirstUser.vue';
import chevronRight from '~/assets/icons/chevron_right.svg';
import SpinLoading from '~/components/common/SpinLoading.vue';

definePageMeta({
  layout: 'no-sidebar',
});

const router = useRouter();

const lessonStore = useLessonStore();
const studioStore = useStudioStore();
const lessonBookingStore = useLessonBookingStore();
const userStore = useUserStore();

onMounted(() => {
  const current = history.state.current;
  const forward = history.state.forward;
  if (
    current !== '/firstLessonBooking' ||
    forward !== '/firstLessonBookingConfirm'
  ) {
    lessonBookingStore.initializeErrors();
    lessonBookingStore.initializeFirstBooking();
  }
});

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
  <div class="">
    <Head>
      <title>{{ $t('firstLessonBooking.tabTitle') }}</title>
    </Head>
  </div>

  <div
    v-if="
      lessonBookingStore.isFirstBookingLoading ||
      lessonStore.isStudioLessonLoading
    "
    class="fixed inset-0 bg-opacity-50 z-50"
  ></div>

  <div class="px-4 py-3 space-y-6">
    <FirstSelectedLesson
      :is-studio-lesson-loading="lessonStore.isStudioLessonLoading"
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
      <span
        v-if="!lessonBookingStore.isFirstBookingLoading"
        class="text-white"
        >{{ $t('firstLessonBooking.next') }}</span
      >
      <span
        v-if="lessonBookingStore.isFirstBookingLoading"
        class="flex items-center justify-center"
      >
        <SpinLoading :color="'#FFFFFF'" :width="'22px'" :height="'22px'" />
      </span>
      <img
        class="absolute right-3 top-1/2 -translate-y-1/2"
        :src="chevronRight"
        alt="Chevron Right"
      />
    </button>
  </div>
</template>
