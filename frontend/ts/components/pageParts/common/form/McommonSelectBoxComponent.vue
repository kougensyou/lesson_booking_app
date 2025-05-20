<script setup lang="ts">
  import { ref, Ref } from "vue";

  const props = withDefaults(
    defineProps<{
      // 表示判定
      modelValue: any;
      // master_idに属するデータ
      list: {
        [key: string]: any;
      };
      // 参照カラム
      column: string;
      hidden?: boolean;
    }>(),
    {
      hidden: false
    }
  );

  defineEmits(["update:modelValue"]);

  let sortData: Ref<any[]> = ref([]);
  // ソート
  let temp: Ref<any[]> = ref([]);
  Object.keys(props.list).forEach((id) => {
    temp.value.push(props.list[id]);
  });
  sortData.value = temp.value.sort((a: any, b: any) => {
    return a.sort_seq - b.sort_seq;
  });
</script>

<template>
  <select v-if="list" :value="modelValue" @change="$emit('update:modelValue', ($event.target as any).value)">
    <option v-if="hidden" modelValue=""></option>
    <option v-for="data in sortData" :key="data['item_id']" :value="data['item_id']">
      {{ data[column] }}
    </option>
  </select>
</template>
