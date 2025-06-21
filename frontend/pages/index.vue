<script setup lang="ts">
import { useUserStore } from '../stores/useUserStore';

const user = useUserStore();

const { fetchLoginInfo } = user;

await fetchLoginInfo();
</script>
<template>
  <div class="">
    <div class="bg-gray-200 w-full">
      <div class="max-w-[640px] mx-auto pl-6">
        <div class="text-left pt-8 pb-8 text-xl font-serif font-medium">
          ログイン
        </div>
      </div>
    </div>
    <div class="max-w-[640px] mx-auto pl-6">
      <div class="pt-52 text-left text-slate-500">会員番号</div>
      <input
        v-model="user.loginData.username"
        class="input border-2"
        type="text"
        placeholder="例：test@test.com"
      />
      <div class="pt-12 text-left text-slate-500">パスワード</div>
      <input
        v-model="user.loginData.password"
        class="input border-2"
        type="text"
        placeholder="半角英数字"
      />
    </div>
  </div>
  <button
    class="pt-6 pb-6 pl-3 pr-3 bg-sky-500 rounded-3xl"
    @click="user.login"
  >
    <span class="text-white">ログイン</span>
    <span class="text-white material-symbols-outlined">chevron_right</span>
  </button>
  <div class="">
    <a>パスワードを忘れたら</a>
  </div>
  <div class="">
    <div class="">アカウントをお持ちでない方</div>
    <button class="">
      体験予約
      <span class="">chevron_right</span>
    </button>
  </div>
</template>
