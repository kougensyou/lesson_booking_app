<script setup lang="ts">
  import { useUserStore } from "../stores/useUserStore";

  const user = useUserStore();

  const { fetchLoginInfo } = user;

  await fetchLoginInfo();
</script>
<template>
  <div class="columns cmp-form-search no-border is-multiline">
    <div class="column small is-12 items has-text-grey mt-3">あお</div>
    <div class="column small is-12 cmp-items">
      <input v-model="user.loginData.username" class="input" type="text" placeholder="例：test@test.com" />
    </div>
    <div class="column small is-12 items has-text-grey mt-5">パスワード</div>
    <div class="column small is-12 cmp-items">
      <input v-model="user.loginData.password" class="input" type="text" placeholder="半角英数字" />
    </div>
  </div>
  <button class="button is-primary is-rounded is-fullwidth mt-6 mb-6" @click="user.login">
    ログイン
    <span class="material-symbols-outlined right_arrow">chevron_right</span>
  </button>
  <div class="mt-6 has-text-centered login_link">
    <a>パスワードを忘れたら</a>
  </div>
  <div class="login_footer has-background-white-ter">
    <div class="font-bold is-size-6 mt-6 has-text-centered">アカウントをお持ちでない方</div>
    <button class="has-background-info button is-primary is-rounded is-fullwidth mt-6 mb-6">
      体験予約
      <span class="material-symbols-outlined right_arrow">chevron_right</span>
    </button>
  </div>
</template>
<style>
  .right_arrow {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
  }
  .login_footer {
    position: fixed;
    bottom: 0;
    width: 400px;
  }
  .login_link {
    font-size: 14px;
  }
</style>