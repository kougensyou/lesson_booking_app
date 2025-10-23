<script setup lang="ts">
import type { Attribute, LessonBooking } from '~/types/lessonBooking';
import { Calendar } from 'v-calendar';
import { watch, nextTick } from 'vue';
import RectLoading from '../common/RectLoading.vue';

const props = defineProps<{
  isSelectedLessonLoading: boolean;
  calendarLocale: string;
  selectedLessonList: Array<LessonBooking>;
  attributes: Array<Attribute>;
  calendarThemeColor: string;
  checkToday: (day: number) => boolean;
  getPrevLessonList: () => void;
  getNextLessonList: () => void;
}>();

watch(
  () => props.isSelectedLessonLoading,
  async (loading) => {
    if (!loading) {
      await nextTick();
      const prev = document.querySelector<HTMLElement>('.vc-prev');
      const next = document.querySelector<HTMLElement>('.vc-next');
      if (prev) prev.addEventListener('click', props.getPrevLessonList);
      if (next) next.addEventListener('click', props.getNextLessonList);
    }
  }
);
</script>
<template>
  <h1 class="text-xl font-bold px-4 pt-4">
    {{ $t('home.lessonCalendarTitle') }}
  </h1>

  <div v-if="isSelectedLessonLoading">
    <RectLoading :card-height="'400px'" :card-width="'w-full'" />
  </div>

  <div v-if="!isSelectedLessonLoading" class="custom-calendar m-4">
    <Calendar
      class="max-w-full"
      :masks="{ title: 'YYYY/MM' }"
      :color="calendarThemeColor"
      :attributes="attributes"
      :locale="calendarLocale"
      trim-weeks
      expanded
    >
      <template v-slot:day-content="slotProps">
        <div class="flex flex-col h-full z-10 overflow-hidden">
          <!-- Today -->
          <span
            v-if="checkToday(slotProps.day.day)"
            class="flex items-center justify-center w-6 h-6 rounded-full m-auto bg-black text-white"
          >
            {{ slotProps.day.day }}
          </span>
          <!-- Not Today -->
          <span
            v-else
            class="flex items-center justify-center w-6 h-6 m-auto text-gray-900"
          >
            {{ slotProps.day.day }}
          </span>
          <!-- Booked Lesson -->
          <template v-if="slotProps.attributes.length > 0">
            <!-- Done Booked Lesson -->
            <template
              v-if="
                slotProps.attributes.some(
                  (attr: Attribute) => attr.custom_data.done_flag
                )
              "
            >
              <span
                class="flex items-center justify-center w-full h-full mt-1 mb-1"
              >
                <span
                  class="material-symbols-outlined w-8 h-8 rounded-full bg-green-600 text-white m-auto my-1 flex items-center justify-center"
                  >check</span
                >
              </span>
            </template>
            <!-- Undone Booked Lesson -->
            <template
              v-else-if="
                slotProps.attributes.some(
                  (attr: Attribute) => !attr.custom_data.done_flag
                )
              "
            >
              <span
                class="flex items-center justify-center w-full h-full mt-1 mb-1"
              >
                <span
                  class="w-8 h-8 rounded-full bg-green-100 m-auto my-1"
                ></span>
              </span>
            </template>
          </template>
          <!-- No Booked Lesson -->
          <template v-else>
            <span
              class="flex items-center justify-center w-full h-full mt-1 mb-1"
            >
              <span class="w-8 h-8 rounded-full transparent m-auto my-1"></span>
            </span>
          </template>
        </div>
      </template>
    </Calendar>
  </div>
</template>
<style>
.custom-calendar .vc-bordered {
  border: none;
  border-radius: 1.5rem;
}

.custom-calendar .vc-arrow {
  color: rgb(125 211 252 / 1);
}

.custom-calendar .vc-title {
  color: #71747a;
}
</style>
