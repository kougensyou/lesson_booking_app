<script setup lang="ts">
const year = new Date().getFullYear();
</script>
<template>
  <footer class="bg-white text-center py-6 text-sm text-gray-600 border-t">
    <p>© {{ year }} {{ $t('footer.title') }} All rights reserved.</p>
  </footer>
</template>
