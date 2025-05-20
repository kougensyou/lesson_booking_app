<script setup lang="ts">
  import { getCurrentInstance, ref, Ref, onMounted } from "vue";

  const props = defineProps<{
    text?: string;
    lineless?: boolean;
  }>();

  const self = getCurrentInstance()!.proxy;
  let title: Ref<string> = ref("");

  onMounted(() => {
    if (props.text) {
      title.value = props.text;
    } else if (self!.$route.meta.heading) {
      title.value = (self!.$route as any).meta.heading;
    }
  });
</script>

<template>
  <div class="utl-mlr10 utl-mtb10" :class="{ 'utl-mb20': lineless }">
    <h1 class="title is-5 has-text-centered has-text-grey-dark utl-mb10">{{ title }}</h1>
    <hr v-if="lineless === false" class="hr is-marginless" />
  </div>
</template>
