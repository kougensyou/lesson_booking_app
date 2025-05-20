<script setup lang="ts">
  import { ref, Ref } from "vue";
  import { useRoute } from "vue-router";

  const props = defineProps<{
    // パンくずの設定を変更する場合
    breadcrumb?: Array<string>;
    app: any;
  }>();

  const route = useRoute();

  let list: Ref<string[]> = ref([]);
  // パンくず設定がない場合の判定
  let isBreadcrumb: Ref<boolean> = ref(true);

  if (props.breadcrumb) {
    list.value = props.breadcrumb;
    isBreadcrumb.value = true;
  } else if (route.meta && route.meta.breadcrumb) {
    list.value = route.meta.breadcrumb as string[];
    isBreadcrumb.value = true;
  }
</script>

<template>
  <div class="m-2 mod-breadcrumb">
    <nav class="breadcrumb is-small has-succeeds-separator">
      <ul class="is-align-items-center">
        <li></li>
        <template v-if="isBreadcrumb">
          <li
            v-for="(breadcrumbName, key, index) in list"
            :key="index"
            class="has-text-centerd"
            :class="{ 'is-active': index + 1 === list.length }"
          >
            <router-link :to="{ name: breadcrumbName }">
              {{ $routes[breadcrumbName] }}
            </router-link>
          </li>
        </template>
      </ul>
    </nav>
  </div>
</template>
