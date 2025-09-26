<script setup lang="ts">
import { useUserStore } from '../stores/useUserStore';
import { useApiErrorHandler } from '~/composables/useApiErrorHandler';
import { useRouter } from 'vue-router';

definePageMeta({
  layout: 'no-sidebar',
});

document.fonts.ready.then(() => {
  document.documentElement.classList.add('font-loaded');
});

const router = useRouter();

const userStore = useUserStore();

userStore.initializeErrors();

const login = () => {
  userStore.loginApi().catch((error: any) => {
    useApiErrorHandler(router, error);
  });
};
</script>
<template>
  <div class="pt-2 pb-2">
    <Head>
      <title>{{ $t('index.tabTitle') }}</title>
    </Head>
    <div class="mt-4 mb-4 p-4 bg-white max-w-[640px] mx-auto">
      <div class="flex items-center justify-center">
        {{ $t('index.title') }}
      </div>
      <div class="pb-2 text-left text-slate-500">
        {{ $t('index.email') }}
      </div>
      <input
        v-model="userStore.loginData.email"
        class="input border-2 p-2 w-full"
        type="text"
        :placeholder="$t('index.emailPlaceholder')"
      />
      <template v-for="errorMessage in userStore.errors?.email">
        <div class="text-red-600 w-full">
          {{ errorMessage }}
        </div>
      </template>
      <div class="pb-2 text-left text-slate-500">
        {{ $t('index.password') }}
      </div>
      <input
        v-model="userStore.loginData.password"
        class="input border-2 p-2 w-full"
        type="password"
        :placeholder="$t('index.passwordPlaceholder')"
      />
      <template v-for="errorMessage in userStore.errors?.password">
        <div class="text-red-600 w-full">
          {{ errorMessage }}
        </div>
      </template>
      <button
        class="mt-12 w-full bg-sky-500 rounded-3xl py-4 relative group font-loaded"
        @click="login()"
      >
        <span class="text-white">{{ $t('index.loginButton') }}</span>
        <span
          class="text-transparent material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 invisible group-[.font-loaded]:visible group-[.font-loaded]:text-white"
          aria-hidden="true"
        >
          chevron_right
        </span>
      </button>
      <div class="flex items-center justify-center mt-6">
        <a
          class="text-sm text-sky-600 underline underline-offset-4"
          @click="$router.push('/passwordReset')"
          >{{ $t('index.forgetPassword') }}</a
        >
      </div>
    </div>
    <div class="bg-white max-w-[640px] mx-auto p-6">
      <div class="flex items-center justify-center">
        <div class="font-bold">{{ $t('index.noAccount') }}</div>
      </div>
      <button
        class="mt-12 bg-orange-500 rounded-3xl w-full py-4 relative group font-loaded"
        @click="$router.push('/firstLessonBooking')"
      >
        <span class="text-white">{{ $t('index.firstLesson') }}</span>
        <span
          class="text-transparent material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 invisible group-[.font-loaded]:visible group-[.font-loaded]:text-white"
          aria-hidden="true"
          >chevron_right</span
        >
      </button>
    </div>
  </div>
</template>
