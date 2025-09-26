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

    <template v-for="errorMessage in errors?.name">
      <div class="text-red-600 w-full">
        {{ errorMessage }}
      </div>
    </template>
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

    <template v-for="errorMessage in errors?.birth_date">
      <div class="text-red-600 w-full">
        {{ errorMessage }}
      </div>
    </template>
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

    <template v-for="errorMessage in errors?.email">
      <div class="text-red-600 w-full">
        {{ errorMessage }}
      </div>
    </template>
  </div>
</template>
