<script setup lang="ts">
  import { useLogout } from "../store/useLogout";

  const { logout } = useLogout();

  logout();
</script>

<!--<style scoped>-->
<template>
  <div></div>
</template>
