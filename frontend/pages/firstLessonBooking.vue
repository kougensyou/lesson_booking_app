<script setup lang="ts">
import { useLessonStore } from '~/stores/useLessonStore';
import { useStudioStore } from '~/stores/useStudioStore';
import { useLessonBookingStore } from '~/stores/useLessonBookingStore';

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
    <div>
      <label class="block text-sm font-medium">{{
        $t('firstLessonBooking.lessonCategory')
      }}</label>
      <select
        class="w-full border p-1 rounded"
        v-model="
          lessonBookingStore.firstBooking.selectedLesson.lesson_category_name
        "
      >
        <option value="">-</option>
        <option
          v-for="category in lessonStore.lessonCategoryList"
          :key="category.id"
          :value="category.category_name"
        >
          {{ category.category_name }}
        </option>
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium">{{
        $t('firstLessonBooking.studio')
      }}</label>
      <select
        class="w-full border p-1 rounded"
        v-model="lessonBookingStore.firstBooking.selectedLesson.studio_name"
      >
        <option value="">-</option>
        <option
          v-for="studio in studioStore.studioList"
          :key="studio.id"
          :value="studio.studio_name"
        >
          {{ studio.studio_name }}
        </option>
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium">{{
        $t('firstLessonBooking.name')
      }}</label>
      <input
        v-model="lessonBookingStore.firstBooking.user.name"
        type="text"
        class="mt-1 w-full rounded border p-2"
      />
    </div>

    <div>
      <label class="block text-sm font-medium">{{
        $t('firstLessonBooking.birthDay')
      }}</label>
      <input
        v-model="lessonBookingStore.firstBooking.user.birth_date"
        type="text"
        class="mt-1 w-full rounded border p-2"
      />
    </div>

    <div>
      <label class="block text-sm font-medium">{{
        $t('firstLessonBooking.email')
      }}</label>
      <input
        v-model="lessonBookingStore.firstBooking.user.email"
        type="text"
        class="mt-1 w-full rounded border p-2"
      />
    </div>

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
