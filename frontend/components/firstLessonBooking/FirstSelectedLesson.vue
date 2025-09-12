<script setup lang="ts">
import type { LessonCategory, StudioLesson, WeekData } from '~/types/lesson';
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
  </div>

  <StudioLessonCalendar
    v-if="selectedLesson.studio_name"
    :is-auth="isAuth"
    :week-data="weekData"
    :studio-lesson-list="studioLessonList"
    :time-options="timeOptions"
    :change-studio-lesson-data="changeStudioLessonData"
    :click-card="
      (studioLesson: any) => {
        $router.push({
          path: '/lessonDetail',
          query: { lesson_id: studioLesson.lesson_id },
        });
      }
    "
  />
</template>
