<script setup lang="ts">
import { useUserStore } from '../stores/useUserStore';
import { useApiErrorHandler } from '~/composables/useApiErrorHandler';
import { useRouter } from 'vue-router';
import Toast from '~/components/common/Toast.vue';
// import SpinLoading from '~/components/common/SpinLoading.vue';
import chevronRight from '~/assets/icons/chevron_right.svg';

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
  <div class="">
    <Head>
      <title>{{ $t('passwordReset.tabTitle') }}</title>
    </Head>
  </div>

  <div
    v-if="userStore.isUserLoading"
    class="fixed inset-0 bg-opacity-50 z-50"
  ></div>

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

      <!-- <button
        class="mt-12 bg-sky-500 rounded-3xl w-full py-4 relative"
        @click="sendPasswordResetMail()"
      >
        <span v-if="!userStore.isUserLoading" class="text-white">{{
          $t('passwordReset.sendButton')
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
    </div>
    <div class="mt-4 mb-4 bg-white max-w-[640px] mx-auto p-6">
      <div class="flex items-center justify-center">
        <div class="font-bold">{{ $t('index.noAccount') }}</div>
      </div>
      <button
        class="mt-12 bg-orange-500 rounded-3xl w-full py-4 relative"
        @click="$router.push('/firstLessonBooking')"
      >
        <span class="text-white">{{ $t('index.firstLesson') }}</span>
        <img
          class="absolute right-3 top-1/2 -translate-y-1/2"
          :src="chevronRight"
          alt="Chevron Right"
        />
      </button>
    </div>
  </div>
  <Toast :show="userStore.toastVisible" :message="userStore.toastMessage" />
</template>
