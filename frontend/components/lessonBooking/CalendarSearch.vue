<script setup lang="ts">
import { Calendar } from 'v-calendar';

const props = defineProps<{
  calendarThemeColor: string;
  calendarLocale: string;
  checkSelected: Function;
  changeByPrev: Function;
  changeByNext: Function;
  removeSelected: Function;
  addSelected: Function;
}>();

onMounted(() => {
  const prev = document.querySelector('.vc-prev');
  const next = document.querySelector('.vc-next');
  prev?.addEventListener('click', async () => {
    await props.changeByPrev();
  });
  next?.addEventListener('click', async () => {
    await props.changeByNext();
  });
});
</script>
<template>
  <div class="custom-calendar px-4 py-2">
    <Calendar
      class="max-w-full"
      :masks="{ title: 'YYYY/MM' }"
      :color="calendarThemeColor"
      :locale="calendarLocale"
      trim-weeks
      expanded
    >
      <template v-slot:day-content="slotProps">
        <div class="flex flex-col h-full z-10 overflow-hidden">
          <!-- Selected Day -->
          <span
            v-if="checkSelected(slotProps.day.day)"
            class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-300 text-white m-auto my-1"
            @click="removeSelected(slotProps.day.day)"
          >
            {{ slotProps.day.day }}
          </span>
          <!-- Not Selected Day -->
          <span
            v-else
            class="flex items-center justify-center text-sm w-8 h-8 text-gray-900 m-auto my-1"
            @click="addSelected(slotProps.day.day)"
          >
            {{ slotProps.day.day }}
          </span>
        </div>
      </template>
    </Calendar>
  </div>
</template>
<style scoped>
.custom-calendar :deep(.vc-bordered) {
  border: none;
  border-radius: 1.5rem;
}
</style>
