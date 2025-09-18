<template>
  <span class="spinLoader"></span>
</template>
<style>
.spinLoader {
  width: 36px;
  height: 36px;
  border: 4px solid #5d5656f1;
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
