<script setup lang="ts">
import type { Attribute, LessonBooking } from '~/types/lessonBooking';
import { Calendar } from 'v-calendar';

const props = defineProps<{
  calendarLocale: string;
  selectedLessonList: Array<LessonBooking>;
  attributes: Array<Attribute>;
  calendarThemeColor: string;
  checkToday: Function;
  getPrevLessonList: Function;
  getNextLessonList: Function;
}>();

onMounted(() => {
  const prev = document.querySelector('.vc-prev');
  const next = document.querySelector('.vc-next');
  prev?.addEventListener('click', async () => {
    await props.getPrevLessonList();
  });
  next?.addEventListener('click', async () => {
    await props.getNextLessonList();
  });
});
</script>
<template>
  <h1 class="text-xl font-bold px-4 pt-4">
    {{ $t('home.lessonCalendarTitle') }}
  </h1>
  <div class="custom-calendar px-4 py-2">
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
          <span v-if="checkToday(slotProps.day.day)">
            <span
              class="flex items-center justify-center w-6 h-6 rounded-full bg-black text-white m-auto"
            >
              {{ slotProps.day.day }}
            </span>
          </span>
          <span v-else class="text-center text-sm text-gray-900">
            {{ slotProps.day.day }}
          </span>
          <template v-if="slotProps.attributes.length > 0">
            <template
              v-if="
                slotProps.attributes.some(
                  (attr: Attribute) => attr.customData.done_flag
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
            <template
              v-else-if="
                slotProps.attributes.some(
                  (attr: Attribute) => !attr.customData.done_flag
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

/* .custom-calendar .vc-nav-arrow {
  color: rgb(125 211 252 / 1);
}

.custom-calendar .vc-nav-title {
  color: #71747a;
} */
</style>
