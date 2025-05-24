<script setup lang="ts">
  import { ref, Ref } from "vue";

  const props = defineProps<{
    // モーダル表示判定
    show: boolean;
    // submit, cancelを独自に作る場合に使用
    onlyContent?: boolean;
    // ウィンドウサイズ
    isMedium?: boolean;
  }>();

  defineEmits(["closed", "execute"]);

  let size: Ref<string> = ref("");

  if (props.isMedium) {
    size.value = "80%";
  }
</script>

<template>
  <div class="modal is-mobile cmp-modal-full" :class="{ 'is-active': show }">
    <div class="modal-background"></div>
    <div class="modal-content" :style="{ width: size }">
      <div class="box">
        <div class="content">
          <slot name="content"></slot>
        </div>
        <template v-if="onlyContent !== true">
          <div class="level">
            <div class="level-item has-text-centered">
              <template v-if="$slots.submit">
                <p class="control mr-3">
                  <a class="button is-small is-rounded is-primary utl-plr20" @click="$emit('execute')">
                    <slot name="submit"></slot>
                  </a>
                </p>
              </template>
              <p class="control">
                <a class="button is-light is-small is-rounded utl-plr20" @click="$emit('closed')">
                  <template v-if="$slots.cancel">
                    <slot name="cancel"></slot>
                  </template>
                  <template v-else> キャンセル </template>
                </a>
              </p>
            </div>
          </div>
        </template>
      </div>
    </div>
  </div>
</template>
