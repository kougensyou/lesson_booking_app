<script setup lang="ts">
  import {} from "vue";

  const props = defineProps<{
    errors: Array<string>;
  }>();
</script>

<template>
  <div>
    <p v-for="(error, i) in props.errors" :key="i" class="help is-danger">{{ error }}</p>
  </div>
</template>
