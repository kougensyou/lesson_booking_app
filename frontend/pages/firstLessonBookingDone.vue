<script setup lang="ts">
import { useLessonBookingStore } from '../stores/useLessonBookingStore';

definePageMeta({
  layout: 'no-sidebar',
});

const lessonBookingStore = useLessonBookingStore();
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('firstLessonBookingDone.tabTitle') }}</title>
    </Head>
  </div>

  <!-- Done Message -->
  <div class="p-4">
    <h2 class="text-l text-center mb-4 whitespace-pre-line">
      {{ $t('firstLessonBookingDone.doneMessage') }}
    </h2>

    <div class="bg-white shadow-md rounded-lg p-4 mb-4">
      <div class="text-center text-2xl font-semibold my-2">
        {{ lessonBookingStore.firstBooking.user.email }}
      </div>
    </div>
  </div>
</template>
