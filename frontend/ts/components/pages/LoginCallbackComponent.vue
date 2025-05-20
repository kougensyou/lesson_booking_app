<script setup lang="ts">
  import { useRoute } from "vue-router";
  import { useLogin } from "../../hooks/useLogin";

  const { loginCallback } = useLogin();

  const route = useRoute();
  loginCallback(route.query.code as string);
</script>

<template>
  <div></div>
</template>
