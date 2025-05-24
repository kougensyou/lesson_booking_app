<script setup lang="ts">
  import {} from "vue";

  const props = defineProps<{
    errors: Object;
  }>();
</script>

<template>
  <div class="message is-danger">
    <div class="message-body">
      <ul>
        <li v-for="(error, i) in props.errors" :key="i">
          <p v-for="(datail, j) in error" :key="j">{{ datail }}</p>
        </li>
      </ul>
    </div>
  </div>
</template>
