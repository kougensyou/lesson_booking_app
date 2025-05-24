<script setup lang="ts">
  import { ref } from "vue";

  defineProps<{
    app: any;
  }>();

  // メニューの表示フラグ
  const menuChecked = ref(false);

  // メニューの表示フラグを変更する
  const changeSidebarFlag = () => {
    menuChecked.value = !menuChecked.value;
  };
</script>

<template>
  <div class="modal sidebar-parent" :class="{ 'is-active': menuChecked }">
    <div :class="{ 'modal-background': menuChecked }" @click="changeSidebarFlag"></div>
    <div class="sidebar" :style="{ left: !menuChecked ? '-300px' : '0' }">
      <sidebar-component :app="app" :menu-checked="menuChecked" @change-sidebar-flag="changeSidebarFlag" />
    </div>
  </div>
  <nav class="has-text-centerd m-2">
    <input class="menu-check" type="checkbox" />
    <label for="menu-check">
      <span
        class="material-symbols-outlined menu-btn"
        :class="{ 'menu-btn-checked': menuChecked }"
        @click="changeSidebarFlag"
        >menu</span
      >
    </label>
    <ul class="ml-5 is-flex">
      <p v-if="app.user" class="is-size-6 three-dots-reader" :title="app.user.name" :style="{ 'max-width': '55%' }">
        {{ app.user.name }} さん &nbsp;
      </p>
    </ul>
  </nav>
  <hr class="hr is-marginless" />
</template>
