<script setup lang="ts">
import { useUserStore } from '../stores/useUserStore';

definePageMeta({
  layout: 'no-header',
});

const user = useUserStore();
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('index.tabTitle') }}</title>
    </Head>
    <div class="bg-gray-200 w-full">
      <div class="max-w-[640px] mx-auto pl-6">
        <div class="text-left pt-8 pb-8 text-xl font-serif font-medium">
          {{ $t('index.title') }}
        </div>
      </div>
    </div>
    <div class="max-w-[640px] mx-auto pl-6 pr-6">
      <div class="pt-36 pb-2 text-left text-slate-500">
        {{ $t('index.email') }}
      </div>
      <input
        v-model="user.loginData.email"
        class="input border-2 p-2 w-full"
        type="text"
        :placeholder="$t('index.emailPlaceholder')"
      />
      <div class="pt-12 pb-2 text-left text-slate-500">
        {{ $t('index.password') }}
      </div>
      <input
        v-model="user.loginData.password"
        class="input border-2 p-2 w-full"
        type="text"
        :placeholder="$t('index.passwordPlaceholder')"
      />
      <button
        class="mt-12 pt-6 pb-6 pl-3 pr-3 bg-sky-500 rounded-3xl w-full relative"
        @click="user.login()"
      >
        <span class="text-white">{{ $t('index.loginButton') }}</span>
        <span
          class="text-white material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2"
          >chevron_right</span
        >
      </button>
      <div class="flex items-center justify-center mt-6">
        <a class="text-sm text-sky-600 underline underline-offset-4">{{
          $t('index.forgetPassword')
        }}</a>
      </div>
    </div>
    <div class="bg-gray-200 w-full">
      <div class="max-w-[640px] mx-auto pl-6 pr-6 pb-6">
        <div class="flex items-center justify-center mt-24">
          <div class="pt-6 font-bold">{{ $t('index.noAccount') }}</div>
        </div>
        <button
          class="mt-12 pt-6 pb-6 bg-orange-500 rounded-3xl w-full relative"
          @click=""
        >
          <span class="text-white">{{ $t('index.firstLesson') }}</span>
          <span
            class="text-white material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2"
            >chevron_right</span
          >
        </button>
      </div>
    </div>
  </div>
</template>
