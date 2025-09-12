<script setup lang="ts">
defineProps<{
  isOpen: boolean;
  closeSidebar: () => void;
}>();
</script>
<template>
  <div>
    <div
      v-if="isOpen"
      class="fixed inset-0 bg-black bg-opacity-25 z-40"
      @click="closeSidebar"
    ></div>
    <aside
      :class="[
        'fixed top-0 right-0 w-64 h-full shadow-lg transform transition-transform duration-500 bg-white z-50',
        isOpen ? 'translate-x-0' : 'translate-x-full',
      ]"
    >
      <div class="flex justify-between items-center p-4 border-b">
        <button @click="closeSidebar" class="ml-auto">
          <span class="material-symbols-outlined" aria-hidden="true"
            >close</span
          >
        </button>
      </div>
      <ul class="space-y-2 font-serif text-xl">
        <li class="pl-4 pb-4">
          <NuxtLink to="/home" @click="closeSidebar">{{
            $t('sidebar.home')
          }}</NuxtLink>
        </li>
        <li class="pl-4 pb-4">
          <NuxtLink to="/lessonBooking" @click="closeSidebar">{{
            $t('sidebar.lessonBooking')
          }}</NuxtLink>
        </li>
        <li class="pl-4 pb-4">
          <NuxtLink to="/bookingHistory" @click="closeSidebar">{{
            $t('sidebar.bookingHistory')
          }}</NuxtLink>
        </li>
        <li class="pl-4 pb-4">
          <NuxtLink to="/memberInfo" @click="closeSidebar">{{
            $t('sidebar.memberInfo')
          }}</NuxtLink>
        </li>
      </ul>
    </aside>
  </div>
</template>
