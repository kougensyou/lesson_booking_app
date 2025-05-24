<script setup lang="ts">
  import { useLogin } from "../store/useLogin";

  const { getLoginInfo, login, email, password } = useLogin();

  getLoginInfo();

  // let authData = sessionStorage.getItem("authData");
  // sessionStorage.removeItem("batchManagementSearch");
  // sessionStorage.setItem("batchManagementSearch", JSON.stringify(search));
</script>

<!--<style scoped>-->
<template>
  <div class="columns cmp-form-search no-border is-multiline">
    <div class="column is-12 items font-bold is-size-6 pt-5 pb-5 mb-6 has-background-white-ter">ログイン</div>
    <div class="column small is-12 items has-text-grey mt-3">メールアドレス</div>
    <div class="column small is-12 cmp-items">
      <input v-model="email" class="input" type="text" placeholder="例：test@test.com" />
    </div>
    <div class="column small is-12 items has-text-grey mt-5">パスワード</div>
    <div class="column small is-12 cmp-items">
      <input v-model="password" class="input" type="text" placeholder="半角英数字" />
    </div>
  </div>
  <button class="button is-primary is-rounded is-fullwidth mt-6 mb-6" @click="login">
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
