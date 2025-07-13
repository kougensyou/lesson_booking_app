<script setup lang="ts">
import { ref } from 'vue';

const wrapper = ref<HTMLElement | null>(null);
const container = ref<HTMLElement | null>(null);

let isDragging = false;
let startX = 0;
let currentX = 0;
let prevTranslateX = 0;
let translateX = ref(0);
let velocity = 0;
let animationFrame: number | null = null;

const clamp = (val: number, min: number, max: number) =>
  Math.max(min, Math.min(max, val));

const getMaxTranslate = () => {
  if (!wrapper.value || !container.value) return 0;
  return wrapper.value.offsetWidth - container.value.scrollWidth;
};

const startDrag = (e: MouseEvent | TouchEvent) => {
  isDragging = true;
  startX = 'touches' in e ? e.touches[0].pageX : e.pageX;
  prevTranslateX = translateX.value;
};

const onDrag = (e: MouseEvent | TouchEvent) => {
  if (!isDragging) return;
  const x = 'touches' in e ? e.touches[0].pageX : e.pageX;
  const deltaX = x - startX;
  currentX = prevTranslateX + deltaX;
  translateX.value = clamp(currentX, getMaxTranslate(), 0);
  velocity = deltaX;
};

const endDrag = () => {
  isDragging = false;
  inertiaScroll();
};

const inertiaScroll = () => {
  const friction = 0.1;
  const animate = () => {
    velocity *= friction;
    if (Math.abs(velocity) < 0.5) return;
    translateX.value = clamp(translateX.value + velocity, getMaxTranslate(), 0);
    animationFrame = requestAnimationFrame(animate);
  };
  animationFrame = requestAnimationFrame(animate);
};

const startTouch = (e: TouchEvent) => {
  if (!e.touches.length) return;
  isDragging = true;
  startX = e.touches[0].pageX;
  prevTranslateX = translateX.value;
};

const onTouch = (e: TouchEvent) => {
  if (!isDragging) return;
  const x = e.touches[0].pageX;
  const deltaX = x - startX;
  currentX = prevTranslateX + deltaX;
  translateX.value = clamp(currentX, getMaxTranslate(), 0);
  velocity = deltaX;
};
</script>
<template>
  <div
    ref="wrapper"
    class="overflow-hidden px-4 py-2"
    @mousedown="startDrag"
    @mousemove="onDrag"
    @mouseup="endDrag"
    @mouseleave="endDrag"
    @touchstart="startTouch"
    @touchmove="onTouch"
    @touchend="endDrag"
  >
    <div
      ref="container"
      class="flex gap-4 transition-transform duration-0 will-change-transform"
      :style="{ transform: `translate3d(${translateX}px, 0, 0)` }"
    >
      <slot />
    </div>
  </div>
</template>
