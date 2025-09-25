<script setup lang="ts">
import type { FirstUser } from '~/types/lessonBooking';

defineProps<{
  user: FirstUser;
  errors: any;
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

    <span class="text-red-600" v-if="errors?.name">{{ errors.name[0] }}</span>
  </div>

  <div>
    <label class="block text-sm font-medium">{{
      $t('firstLessonBooking.birthDay')
    }}</label>
    <input
      v-model="user.birth_date"
      type="date"
      class="mt-1 w-full rounded border p-2"
    />

    <span class="text-red-600" v-if="errors?.birth_date">{{
      errors.birth_date[0]
    }}</span>
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

    <span class="text-red-600" v-if="errors?.email">{{ errors.email[0] }}</span>
  </div>
</template>
