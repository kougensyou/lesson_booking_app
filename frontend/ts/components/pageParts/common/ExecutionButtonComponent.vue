<script setup lang="ts">
  import { ref, Ref, onMounted } from "vue";

  const props = defineProps<{
    text?: string;
    params?: any;
    size?: string;
    disabled?: boolean;
  }>();
  defineEmits(["executeButton"]);

  let executionText: Ref<string> = ref("");

  onMounted(() => {
    executionText.value = props.text ? props.text : "実行";
  });
</script>

<template>
  <div class="control">
    <button
      class="button is-rounded is-small is-primary"
      :disabled="disabled"
      :class="{ 'utl-plr40': size !== 'small', 'utl-plr20': size === 'small' }"
      @click="$emit('executeButton', params)"
    >
      {{ executionText }}
    </button>
  </div>
</template>
