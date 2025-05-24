<script setup lang="ts">
  defineProps<{
    app: any;
    menuChecked: boolean;
  }>();

  defineEmits(["changeSidebarFlag"]);
</script>
<template>
  <header>
    <nav class="utl-pl10 has-text-weight-medium">
      <ul class="is-flex">
        <p class="is-size-6">{{ app.user.id }}&nbsp;</p>
        <p class="is-size-6 three-dots-reader" :title="app.user.name" :style="{ 'max-width': '60%' }">
          /&nbsp;{{ app.user.name }}&nbsp;さん
        </p>
        <div class="is-flex-grow-1 is-flex is-justify-content-flex-end">
          <span
            class="material-symbols-outlined mt-3 cancel-btn"
            :class="{ 'cancel-btn-checked': menuChecked }"
            :style="{ left: !menuChecked ? '-300px' : '0' }"
            @click="$emit('changeSidebarFlag')"
            >close</span
          >
        </div>
      </ul>
    </nav>
  </header>

  <ul class="menu-list">
    <router-link :to="{ name: 'deliveryHistoryList' }" @click="$emit('changeSidebarFlag')">
      <div class="is-flex is-align-items-center">
        <span class="material-symbols-outlined orange">manage_search</span>
        配送履歴
      </div>
    </router-link>
  </ul>

  <hr class="hr is-marginless" />

  <ul class="menu-list">
    <a href="/logout">
      <div class="is-flex is-align-items-center">
        <span class="material-symbols-outlined orange">logout</span>
        ログアウト
      </div>
    </a>
  </ul>

  <hr class="hr is-marginless" />
</template>
