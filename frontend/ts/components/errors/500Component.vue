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
            <p class="title is-1 has-text-centered utl-mb40">500 Internal Server Error.</p>
            <hr class="hr utl-mb40" />
            <p class="has-text-centered is-size-6">内部エラーが発生しました。</p>
            <p class="has-text-centered is-size-6 utl-mb40">システム管理者に連絡してください。</p>
            <button class="is-fullwidth button is-small is-primary is-size-6" @click="logIn">
              ログインページに戻る
            </button>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
