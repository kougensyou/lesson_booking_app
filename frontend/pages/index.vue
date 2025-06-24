<script setup lang="ts">
import { useUserStore } from '../stores/useUserStore';

const user = useUserStore();

const { fetchLoginInfo } = user;

await fetchLoginInfo();
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
    <div class="max-w-[640px] mx-auto pl-6">
      <div class="pt-52 text-left text-slate-500">{{ $t('index.email') }}</div>
      <input
        v-model="user.loginData.username"
        class="input border-2"
        type="text"
        :placeholder="$t('index.emailPlaceholder')"
      />
      <div class="pt-12 text-left text-slate-500">
        {{ $t('index.password') }}
      </div>
      <input
        v-model="user.loginData.password"
        class="input border-2"
        type="text"
        :placeholder="$t('index.passwordPlaceholder')"
      />
    </div>
  </div>
  <button
    class="pt-6 pb-6 pl-3 pr-3 bg-sky-500 rounded-3xl"
    @click="user.login"
  >
    <span class="text-white">{{ $t('index.loginButton') }}</span>
    <span class="text-white material-symbols-outlined">chevron_right</span>
  </button>
  <div class="">
    <a>{{ $t('index.forgetPassword') }}</a>
  </div>
  <div class="">
    <div class="">{{ $t('index.noAccount') }}</div>
    <button class="">
      {{ $t('index.firstLesson') }}
      <span class="">chevron_right</span>
    </button>
  </div>
</template>
