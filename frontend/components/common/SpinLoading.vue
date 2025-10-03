<script setup>
defineProps({
  width: {
    type: String,
    default: '36px',
  },
  height: {
    type: String,
    default: '36px',
  },
  color: {
    type: String,
    default: '#5d5656f1',
  },
});
</script>
<template>
  <span
    class="spinLoading"
    :style="{
      '--loader-color': color,
      '--loader-width': width,
      '--loader-height': height,
    }"
  ></span>
</template>
<style>
.spinLoading {
  width: var(--loader-width);
  height: var(--loader-height);
  border: 4px solid var(--loader-color);
  border-bottom-color: transparent;
  border-radius: 50%;
  display: inline-block;
  box-sizing: border-box;
  animation: rotation 0.8s linear infinite;
}

@keyframes rotation {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
