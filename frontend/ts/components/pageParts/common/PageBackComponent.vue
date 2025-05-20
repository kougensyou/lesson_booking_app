<script setup lang="ts">
  import { getCurrentInstance, ref, Ref, onMounted } from "vue";
  import { GeneralInterface } from "../../../interface/CommonInterface";

  const props = defineProps<{
    text?: string;
    // ルーティングで設定した name を指定
    // 指定がない場合は history の1つ前に遷移
    to?: string;
    // 遷移先のURLパラメータ
    query?: Object;
    // 遷移先に渡すパラメータ
    params?: any;
    size?: string;
  }>();

  const self = getCurrentInstance()!.proxy;
  let cancelText: Ref<string> = ref("");

  onMounted(() => {
    cancelText.value = props.text ? props.text : "戻る";
  });

  // historyか指定先に戻る
  const pageBack = () => {
    if (props.to) {
      let setting: GeneralInterface = {
        name: props.to
      };

      if (props.query !== null) {
        setting.query = props.query;
      }

      if (props.params) {
        setting.params = props.params;
      }
      self!.$router.push(setting);
    } else {
      self!.$router.go(-1);
    }
  };
</script>

<template>
  <div class="control">
    <button
      class="button is-small is-primary is-outlined"
      :class="{ 'utl-plr40': size !== 'small', 'utl-plr20': size === 'small' }"
      @click="pageBack"
    >
      {{ cancelText }}
    </button>
  </div>
</template>
