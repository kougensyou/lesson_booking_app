<script setup lang="ts">
import { useUserStore } from '../stores/useUserStore';
import Toast from '~/components/common/toast.vue';

const userStore = useUserStore();
userStore.setToastMessageForPasswordReset();
</script>
<template>
  <div class="max-w-[640px] mx-auto pl-6 pr-6">
    <div class="text-center mb-6">
      <p class="text-gray-700">{{ $t('passwordReset.resetMessage1') }}</p>
      <p class="text-gray-700">{{ $t('passwordReset.resetMessage2') }}</p>
    </div>

    <input
      type="email"
      :placeholder="$t('passwordReset.emailPlaceholder')"
      v-model="userStore.emailForPasswordReset"
      class="w-full max-w-md border rounded px-4 py-2 mb-4 text-gray-800"
    />

    <button
      class="mt-12 pt-6 pb-6 pl-3 pr-3 bg-sky-500 rounded-3xl w-full relative group font-loaded"
      @click="userStore.sendPasswordResetMail()"
    >
      <span class="text-white">{{ $t('passwordReset.sendButton') }}</span>
      <span
        class="material-symbols-outlined absolute right-3"
        aria-hidden="true"
      >
        chevron_right
      </span>
    </button>

    <div class="flex items-center justify-center mt-24">
      <div class="pt-6 font-bold">{{ $t('passwordReset.noAccount') }}</div>
    </div>
    <button
      class="mt-12 pt-6 pb-6 bg-orange-500 rounded-3xl w-full relative"
      @click=""
    >
      <span class="text-white">{{ $t('passwordReset.firstLesson') }}</span>
      <span
        class="material-symbols-outlined absolute right-3"
        aria-hidden="true"
        >chevron_right</span
      >
    </button>
  </div>
  <Toast :show="userStore.toastVisible" :message="userStore.toastMessage" />
</template>
