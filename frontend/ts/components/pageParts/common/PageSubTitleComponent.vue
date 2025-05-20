<script setup lang="ts">
  import { ref, Ref, onMounted } from "vue";

  const props = defineProps<{
    text?: string;
  }>();

  let subTitle: Ref<string> = ref("");

  onMounted(() => {
    subTitle.value = props.text ? props.text : "検索条件";
  });
</script>

<template>
  <div>
    <p class="mod-subtitle">{{ subTitle }}</p>
  </div>
</template>
