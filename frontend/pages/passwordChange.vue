<script setup lang="ts">
import { useUserStore } from '../stores/useUserStore';
import { useApiErrorHandler } from '~/composables/useApiErrorHandler';
import { useRouter } from 'vue-router';
import Toast from '~/components/common/Toast.vue';

definePageMeta({
  middleware: 'auth',
});

const router = useRouter();
const userStore = useUserStore();
userStore.initializePasswordData();
userStore.setToastMessageForPassword();

const updatePassword = () => {
  userStore.updatePasswordApi().catch((error: any) => {
    useApiErrorHandler(router, error);
  });
};
</script>
<template>
  <div class="max-w-[640px] mx-auto p-6">
    <h1 class="text-xl font-bold text-center mb-2">
      {{ $t('passwordChange.passwordChange') }}
    </h1>
    <div class="mb-4">
      <label class="text-left text-slate-500">{{
        $t('passwordChange.currentPassword')
      }}</label>
      <input
        v-model="userStore.passwordData.currentPassword"
        type="password"
        class="w-full border rounded px-3 py-2"
      />
    </div>
    <div class="mb-4">
      <label class="text-left text-slate-500">{{
        $t('passwordChange.newPassword')
      }}</label>
      <input
        v-model="userStore.passwordData.newPassword"
        type="password"
        class="w-full border rounded px-3 py-2"
      />
    </div>

    <div class="mb-4">
      <label class="text-left text-slate-500">{{
        $t('passwordChange.newPasswordConfirmation')
      }}</label>
      <input
        v-model="userStore.passwordData.newPasswordConfirmation"
        type="password"
        class="w-full border rounded px-3 py-2"
      />
    </div>

    <button
      class="mt-12 bg-sky-500 rounded-3xl w-full py-4 relative"
      @click="updatePassword()"
    >
      <span class="text-white">{{ $t('passwordChange.updatePassword') }}</span>
      <span
        class="text-white material-symbols-outlined absolute right-3"
        aria-hidden="true"
      >
        chevron_right
      </span>
    </button>
    <Toast :show="userStore.toastVisible" :message="userStore.toastMessage" />
  </div>
</template>
