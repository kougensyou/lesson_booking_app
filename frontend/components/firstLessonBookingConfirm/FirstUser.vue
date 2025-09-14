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
    {{ user.name }}
  </div>

  <div>
    <label class="block text-sm font-medium">{{
      $t('firstLessonBooking.birthDay')
    }}</label>
    {{ user.birth_date }}
  </div>

  <div>
    <label class="block text-sm font-medium">{{
      $t('firstLessonBooking.email')
    }}</label>
    {{ user.email }}
  </div>
</template>
