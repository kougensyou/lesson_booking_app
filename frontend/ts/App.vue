<script setup lang="ts">
  import { useRouter } from "vue-router";
  import { useLogin } from "./hooks/useLogin";

  const { common } = useLogin();

  document.title = "レッスン予約";
  let router = useRouter();

  router.push({ name: "login" });
</script>

<template>
  <section class="hero">
    <section class="cmp-contents-fullwidth">
      <router-view :app="{ common }" />
    </section>
  </section>
</template>
