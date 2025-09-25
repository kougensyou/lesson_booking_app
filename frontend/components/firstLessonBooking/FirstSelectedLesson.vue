<script setup lang="ts">
import type {
  BaseStudioLesson,
  LessonCategory,
  StudioLesson,
  WeekData,
} from '~/types/lesson';
import type { FirstSelectedLesson } from '~/types/lessonBooking';
import type { Studio } from '~/types/studio';
import StudioLessonCalendar from '../common/StudioLessonCalendar.vue';

defineProps<{
  isAuth: boolean;
  weekData: Array<WeekData>;
  timeOptions: Array<string>;
  studioLessonList: Array<StudioLesson>;
  selectedLesson: FirstSelectedLesson;
  studioList: Array<Studio>;
  lessonCategoryList: Array<LessonCategory>;
  setStudioId: Function;
  getStudioLessonDataApi: Function;
  changeStudioLessonData: Function;
  setFirstSelectedLesson: Function;
  initializeFirstSelectedLesson: Function;
  errors: any;
}>();
</script>
<template>
  <div>
    <label class="block text-sm font-medium">{{
      $t('firstLessonBooking.lessonCategory')
    }}</label>
    <select
      class="w-full border p-1 rounded"
      v-model="selectedLesson.lesson_category_name"
    >
      <option value="">-</option>
      <option
        v-for="category in lessonCategoryList"
        :key="category.id"
        :value="category.category_name"
      >
        {{ category.category_name }}
      </option>
    </select>

    <span class="text-red-600" v-if="errors?.lesson_category_name">{{
      errors.lesson_category_name[0]
    }}</span>
  </div>

  <div>
    <label class="block text-sm font-medium">{{
      $t('firstLessonBooking.studio')
    }}</label>
    <select
      class="w-full border p-1 rounded"
      v-model="selectedLesson.studio_name"
      @change="
        (e: Event) => {
          const target = e.target as HTMLSelectElement | null;
          if (!target) return;
          const studio = studioList.find(
            (s: Studio) => s.studio_name === target.value
          );
          if (studio) setStudioId(studio.id);
          if (!studio) initializeFirstSelectedLesson();
          getStudioLessonDataApi();
        }
      "
    >
      <option value="">-</option>
      <option
        v-for="studio in studioList"
        :key="studio.id"
        :value="studio.studio_name"
      >
        {{ studio.studio_name }}
      </option>
    </select>

    <span class="text-red-600" v-if="errors?.studio_name">{{
      errors.studio_name[0]
    }}</span>
  </div>

  <StudioLessonCalendar
    v-if="selectedLesson.studio_name && selectedLesson.lesson_name === ''"
    :is-auth="isAuth"
    :week-data="weekData"
    :studio-lesson-list="studioLessonList"
    :time-options="timeOptions"
    :change-studio-lesson-data="changeStudioLessonData"
    :click-card="
      (studioLesson: BaseStudioLesson) => {
        setFirstSelectedLesson(studioLesson);
      }
    "
  />

  <div
    v-if="selectedLesson.lesson_name"
    class="border rounded-md p-4 flex items-start mb-6 bg-white"
  >
    <div class="text-center w-24 flex-shrink-0">
      <div class="text-sm font-semibold">
        {{ selectedLesson.studio_name }}
      </div>
      <div class="text-lg font-bold mt-1">
        {{ selectedLesson.lesson_day }}
      </div>
      <div class="text-sm">
        {{ selectedLesson.lesson_time }}
      </div>
    </div>
    <div class="ml-4 flex-1">
      <div class="font-semibold text-base mb-1">
        {{ selectedLesson.lesson_name }}
      </div>
    </div>
  </div>
  <button
    v-if="selectedLesson.lesson_name"
    class="w-full py-3 border border-red-500 text-red-500 font-bold rounded bg-transparent"
    @click="initializeFirstSelectedLesson()"
  >
    <span>{{ $t('firstLessonBooking.change') }}</span>
  </button>
</template>
