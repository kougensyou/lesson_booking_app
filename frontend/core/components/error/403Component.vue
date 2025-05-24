<script setup lang="ts">
  const logIn = () => {
    window.location.href = "/login";
  };
</script>
<template>
  <section class="hero is-fullheight">
    <div class="hero-body is-paddingless">
      <div class="container">
        <div class="columns is-centered">
          <div class="column">
            <p class="title is-1 has-text-centered utl-mb40">Session Timeout.</p>
            <hr class="hr utl-mb40" />
            <p class="has-text-centered is-size-6">セッションタイムアウトしました。</p>
            <p class="has-text-centered is-size-6 utl-mb40">
              お手数ですがログインページより<br />再度ログインください。
            </p>
            <button class="is-fullwidth button is-small is-primary is-size-6" @click="logIn">
              ログインページに戻る
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
