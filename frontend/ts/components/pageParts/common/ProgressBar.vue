<script setup lang="ts">
  import {} from "vue";

  const props = defineProps<{
    // 表示判定
    show: boolean;
  }>();
</script>

<template>
  <div class="modal utl-is-event-none cmp-progressbar" :class="{ 'is-active': props.show }">
    <progress class="progress is-primary" max="100"></progress>
  </div>
</template>
