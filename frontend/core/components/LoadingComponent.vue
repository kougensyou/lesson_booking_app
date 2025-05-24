<script setup lang="ts">
  const props = defineProps<{
    // 表示判定
    show: boolean;
    // ページローディング用（白背景）
    page?: boolean;
  }>();
</script>

<template>
  <div v-if="props.show" class="modal cmp-loading-modal is-active" :class="{ 'cmp-is-page-loading': page }">
    <div class="modal-background"></div>
    <div class="cmp-loading-icon">Loading</div>
  </div>
</template>
