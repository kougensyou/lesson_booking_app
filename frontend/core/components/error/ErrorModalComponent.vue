<script setup lang="ts">
  import { getCurrentInstance, watch, ref, Ref } from "vue";

  const props = withDefaults(
    defineProps<{
      show: boolean;
      errors?: Object;
      // メッセージの自動非表示
      autoHidden?: boolean;
      // 表示時間
      displayTime: number;
      isMedium: boolean;
    }>(),
    {
      errors: undefined,
      autoHidden: true,
      displayTime: 10000,
      isMedium: false
    }
  );

  const self = getCurrentInstance()!.proxy;

  const closed = () => {
    // setTimeoutの処理が重複しないようにする
    clearTimeout((self as any).timeoutId);
    self!.$emit("closed");
  };

  watch(
    () => props.show,
    () => {
      if (props.show === false) {
        return;
      }

      if (props.autoHidden === false) {
        return;
      }

      (self as any).timeoutId = setTimeout(closed, props.displayTime);
    }
  );

  let size: Ref<string> = ref("");

  if (props.isMedium) {
    size.value = "80%";
  }
</script>

<template>
  <div v-if="show" class="modal is-mobile is-active">
    <div class="modal-content" :style="{ width: size }">
      <div class="message is-danger">
        <div class="message-header">
          <p>Error</p>
          <button class="delete" @click="closed"></button>
        </div>
        <div class="message-body">
          <ul>
            <li v-for="(error, i) in props.errors" :key="i">
              <p v-for="(datail, j) in error" :key="j">{{ datail }}</p>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>
