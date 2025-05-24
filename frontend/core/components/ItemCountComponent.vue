<script setup lang="ts">
  import { computed } from "vue";
  import { numberFormat } from "../utils/numberFormat";

  const props = defineProps<{
    count: string;
    beforeText?: string;
  }>();

  const getFormat = computed(() => {
    return numberFormat(props.count);
  });
</script>

<template>
  <p class="utl-mlr20">
    <span class="has-text-weight-bold is-size-5 has-text-primary">{{ beforeText }}{{ getFormat }}</span> 件
  </p>
</template>
