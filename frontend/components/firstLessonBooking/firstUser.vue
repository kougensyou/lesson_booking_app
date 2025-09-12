<script setup lang="ts">
import type { FirstUser } from '~/types/lessonBooking';

defineProps<{
  user: FirstUser;
}>();
</script>
<template>
  <div>
    <label class="block text-sm font-medium">{{
      $t('firstLessonBooking.name')
    }}</label>
    <input
      v-model="user.name"
      type="text"
      class="mt-1 w-full rounded border p-2"
    />
  </div>

  <div>
    <label class="block text-sm font-medium">{{
      $t('firstLessonBooking.birthDay')
    }}</label>
    <input
      v-model="user.birth_date"
      type="text"
      class="mt-1 w-full rounded border p-2"
    />
  </div>

  <div>
    <label class="block text-sm font-medium">{{
      $t('firstLessonBooking.email')
    }}</label>
    <input
      v-model="user.email"
      type="text"
      class="mt-1 w-full rounded border p-2"
    />
  </div>
</template>
