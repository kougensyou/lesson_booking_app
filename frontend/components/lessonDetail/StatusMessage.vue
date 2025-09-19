<script setup lang="ts">
defineProps<{
  doneFlag: boolean;
  bookedFlag: boolean;
  emptyFlag: boolean;
}>();
</script>
<template>
  <p
    v-if="doneFlag && bookedFlag"
    class="text-center mb-2 bg-gray-100 px-4 py-6 rounded"
  >
    {{ $t('lessonDetail.doneMessage') }}
  </p>
  <p
    v-if="!doneFlag && bookedFlag"
    class="text-center mb-2 bg-gray-100 px-4 py-6 rounded"
  >
    {{ $t('lessonDetail.bookingMessage') }}
  </p>
  <p
    v-if="!doneFlag && !bookedFlag && !emptyFlag"
    class="text-center mb-2 bg-gray-100 px-4 py-6 rounded"
  >
    {{ $t('lessonDetail.fullMessage') }}
  </p>
</template>
