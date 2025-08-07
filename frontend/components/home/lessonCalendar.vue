<script setup lang="ts">
import type { Attribute, LessonBooking } from '~/types/home';
import { Calendar } from 'v-calendar';

defineProps<{
  selectedLessonList: Array<LessonBooking>;
  attributes: Array<Attribute>;
  calendarThemeColor: string;
  checkToday: Function;
}>();

const emit = defineEmits(['getPrevLessonList', 'getNextLessonList']);

onMounted(() => {
  const prev = document.querySelector('.vc-prev');
  const next = document.querySelector('.vc-next');
  prev?.addEventListener('click', async () => {
    await emit('getPrevLessonList');
  });
  next?.addEventListener('click', async () => {
    await emit('getNextLessonList');
  });
});
</script>
<template>
  <h1 class="text-xl font-bold px-4 pt-4">
    {{ $t('home.lessonCalendarTitle') }}
  </h1>
  <div class="px-4 py-2">
    <Calendar
      class="custom-calendar max-w-full"
      :color="calendarThemeColor"
      :attributes="attributes"
      expanded
    >
      <template v-slot:day-content="slotProps">
        <div class="flex flex-col h-full z-10 overflow-hidden">
          <span
            v-if="checkToday(slotProps.day.day)"
            class="flex items-center justify-center w-8 h-8 rounded-full bg-black text-white m-auto my-1"
          >
            {{ slotProps.day.day }}
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
                  class="w-8 h-8 rounded-full bg-green-600 m-auto my-1"
                ></span>
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
