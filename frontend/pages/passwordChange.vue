<script setup lang="ts">
import { useUserStore } from '../stores/useUserStore';
import { useApiErrorHandler } from '~/composables/useApiErrorHandler';
import { useRouter } from 'vue-router';
import Toast from '~/components/common/Toast.vue';
// import SpinLoading from '~/components/common/SpinLoading.vue';
// import chevronRight from '~/assets/icons/chevron_right.svg';

definePageMeta({
  middleware: 'auth',
});

const router = useRouter();
const userStore = useUserStore();
userStore.initializeErrors();
userStore.initializePasswordData();
userStore.setToastMessageForPassword();

const updatePassword = () => {
  userStore.updatePasswordApi().catch((error: any) => {
    useApiErrorHandler(router, error);
  });
};
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('passwordChange.tabTitle') }}</title>
    </Head>
  </div>

  <div
    v-if="userStore.isUserLoading"
    class="fixed inset-0 bg-opacity-50 z-50"
  ></div>

  <!-- Input Form -->
  <div class="max-w-[640px] mx-auto p-6">
    <h1 class="text-xl font-bold text-center mb-2">
      {{ $t('passwordChange.passwordChange') }}
    </h1>
    <div class="mb-4">
      <label class="text-left text-slate-500">{{
        $t('passwordChange.currentPassword')
      }}</label>
      <input
        v-model="userStore.passwordData.current_password"
        type="password"
        class="w-full border rounded px-3 py-2"
      />
      <template v-for="errorMessage in userStore.errors?.current_password">
        <div class="text-red-600 w-full">
          {{ errorMessage }}
        </div>
      </template>
    </div>
    <div class="mb-4">
      <label class="text-left text-slate-500">{{
        $t('passwordChange.newPassword')
      }}</label>
      <input
        v-model="userStore.passwordData.new_password"
        type="password"
        class="w-full border rounded px-3 py-2"
      />
      <template v-for="errorMessage in userStore.errors?.new_password">
        <div class="text-red-600 w-full">
          {{ errorMessage }}
        </div>
      </template>
    </div>

    <div class="mb-4">
      <label class="text-left text-slate-500">{{
        $t('passwordChange.newPasswordConfirmation')
      }}</label>
      <input
        v-model="userStore.passwordData.new_password_confirmation"
        type="password"
        class="w-full border rounded px-3 py-2"
      />
      <template
        v-for="errorMessage in userStore.errors?.new_password_confirmation"
      >
        <div class="text-red-600 w-full">
          {{ errorMessage }}
        </div>
      </template>
    </div>

    <!-- <button
      class="mt-12 bg-sky-500 rounded-3xl w-full py-4 relative"
      @click="updatePassword()"
    >
      <span v-if="!userStore.isUserLoading" class="text-white">{{
        $t('passwordChange.updatePassword')
      }}</span>
      <span
        v-if="userStore.isUserLoading"
        class="flex items-center justify-center"
      >
        <SpinLoading :color="'#FFFFFF'" :width="'22px'" :height="'22px'" />
      </span>
      <img
        class="absolute right-3 top-1/2 -translate-y-1/2"
        :src="chevronRight"
        alt="Chevron Right"
      />
    </button> -->
    <button
      class="bg-gray-200 text-gray-500 cursor-not-allowed mt-12 rounded-3xl w-full py-4 relative"
    >
      <span>{{ $t('passwordChange.updatePassword') }}</span>
    </button>

    <!-- Toast Message -->
    <Toast :show="userStore.toastVisible" :message="userStore.toastMessage" />
  </div>
</template>
