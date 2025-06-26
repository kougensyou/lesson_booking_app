<script setup lang="ts">
defineProps<{
  isOpen: boolean;
  closeSidebar: () => void;
}>();
</script>
<template>
  <div>
    <!-- オーバーレイ：グレー背景 -->
    <div
      v-if="isOpen"
      class="fixed inset-0 bg-black bg-opacity-25 z-40"
      @click="closeSidebar"
    ></div>
    <!-- サイドバー：z-50 で最前面かつ常に白背景 -->
    <aside
      :class="[
        'fixed top-0 right-0 w-64 h-full shadow-lg transform transition-transform duration-500 bg-white z-50',
        isOpen ? 'translate-x-0' : 'translate-x-full',
      ]"
    >
      <div class="flex justify-between items-center p-4 border-b">
        <button @click="closeSidebar" class="ml-auto">
          <span class="material-symbols-outlined">close</span>
        </button>
      </div>
      <ul class="space-y-2 font-serif text-xl">
        <li class="pl-4 pb-4">
          <NuxtLink to="/">{{ $t('sidebar.searchLesson') }}</NuxtLink>
        </li>
        <li class="pl-4 pb-4">
          <NuxtLink to="/about">{{ $t('sidebar.memberInfo') }}</NuxtLink>
        </li>
      </ul>
    </aside>
  </div>
</template>
