<script setup lang="ts">
import { useUserStore } from '../stores/useUserStore';
import { useApiErrorHandler } from '~/composables/useApiErrorHandler';
import { useRouter } from 'vue-router';
import Toast from '~/components/common/Toast.vue';

definePageMeta({
  layout: 'no-sidebar',
});

const router = useRouter();

const userStore = useUserStore();
userStore.setToastMessageForPasswordReset();

userStore.initializeErrors();

const sendPasswordResetMail = () => {
  userStore.sendPasswordResetMailApi().catch((error: any) => {
    useApiErrorHandler(router, error);
  });
};
</script>
<template>
  <div class="pt-4 pb-4">
    <div class="max-w-[640px] mx-auto p-4 bg-white">
      <div class="text-center mb-6">
        <p class="text-gray-700">{{ $t('passwordReset.resetMessage1') }}</p>
        <p class="text-gray-700">{{ $t('passwordReset.resetMessage2') }}</p>
      </div>

      <input
        type="email"
        :placeholder="$t('passwordReset.emailPlaceholder')"
        v-model="userStore.emailForPasswordReset"
        class="w-full border rounded px-4 py-2 mb-4 text-gray-800"
      />

      <template v-for="errorMessage in userStore.errors?.email">
        <div class="text-red-600 w-full">
          {{ errorMessage }}
        </div>
      </template>

      <button
        class="mt-12 bg-sky-500 rounded-3xl w-full py-4 relative group font-loaded"
        @click="sendPasswordResetMail()"
      >
        <span class="text-white">{{ $t('passwordReset.sendButton') }}</span>
        <span
          class="text-white material-symbols-outlined absolute right-3"
          aria-hidden="true"
        >
          chevron_right
        </span>
      </button>
    </div>
    <div class="mt-4 mb-4 bg-white max-w-[640px] mx-auto p-6">
      <div class="flex items-center justify-center">
        <div class="font-bold">{{ $t('index.noAccount') }}</div>
      </div>
      <button
        class="mt-12 bg-orange-500 rounded-3xl w-full py-4 relative group font-loaded"
        @click="$router.push('/firstLessonBooking')"
      >
        <span class="text-white">{{ $t('index.firstLesson') }}</span>
        <span
          class="text-white material-symbols-outlined absolute right-3"
          aria-hidden="true"
          >chevron_right</span
        >
      </button>
    </div>
  </div>
  <Toast :show="userStore.toastVisible" :message="userStore.toastMessage" />
</template>
