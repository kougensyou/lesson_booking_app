<script setup lang="ts">
  withDefaults(
    defineProps<{
      // 表示判定
      text?: string;
      disabled?: boolean;
    }>(),
    {
      text: "",
      disabled: false
    }
  );

  defineEmits(["search", "clear"]);
</script>

<template>
  <div class="field is-grouped">
    <div class="control">
      <button class="button is-small is-primary utl-plr20" :disabled="disabled" @click="$emit('search')">
        <template v-if="text">
          {{ text }}
        </template>
        <template v-else> 検索 </template>
      </button>
    </div>
    <div class="control">
      <button class="button is-small is-primary is-outlined utl-plr20" @click="$emit('clear')">リセット</button>
    </div>
  </div>
</template>
