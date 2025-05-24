<script setup lang="ts">
  const props = defineProps<{
    placeholder: string;
    list: Array<{
      id: string;
      name: string;
    }>;
  }>();
  const $emit = defineEmits(["onChange"]);
  const model = defineModel({
    type: String
  });

  /**
   * フォーカスアウト時の処理
   */
  const onBlur = () => {
    for (let i = 0; i < props.list.length; i++) {
      if (props.list[i].id === model.value) {
        $emit("onChange", props.list[i]);
        return;
      }
    }
    $emit("onChange", undefined);
  };
</script>

<template>
  <div>
    <input
      v-model="model"
      list="hogehoge"
      type="text"
      class="input is-small"
      :placeholder="placeholder"
      @blur="onBlur"
    />
    <datalist id="hogehoge">
      <option v-for="(item, index) in list" :key="index" :value="item.id" :label="item.name" />
    </datalist>
  </div>
</template>
