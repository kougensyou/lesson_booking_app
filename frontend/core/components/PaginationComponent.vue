<script setup lang="ts">
  import { ref, Ref, watch, computed } from "vue";
  import { useRoute } from "vue-router";

  const props = defineProps<{
    // 現在ページ数
    currentPage: number;
    // 最後のページ数
    lastPage: number;
    // 余白ありなし
    marginless?: boolean;
  }>();

  defineEmits(["changePage"]);

  const route = useRoute();
  const range = 2; // ページ数の範囲

  // 各ページリンクのURLパラメータ情報
  let firstQuery: Ref<{
    page?: number;
  }> = ref({});
  let lastQuery: Ref<{
    page?: number;
  }> = ref({});
  let prevQuery: Ref<{
    page?: number;
  }> = ref({});
  let nextQuery: Ref<{
    page?: number;
  }> = ref({});
  let list: Ref<any[]> = ref([]);

  // ページリスト取得
  const getPages = () => {
    let pages = [];

    // 現在ページより前のページ範囲
    for (let i = props.currentPage - range; i < props.currentPage; i++) {
      if (i > 1) {
        pages.push(i);
      }
    }

    // 現在ページと後のページ範囲
    for (let i = props.currentPage; i <= props.currentPage + range; i++) {
      if (i < props.lastPage && i > 1) {
        pages.push(i);
      }
    }

    return pages;
  };

  // 初期化
  const init = () => {
    let query: any = JSON.parse(JSON.stringify(route.query));

    // 前へボタン
    query.page = props.currentPage - 1;
    // prevQuery.value = Object.assign({}, query);
    prevQuery.value = JSON.parse(JSON.stringify(query));

    // 次へボタン
    query.page = props.currentPage + 1;
    // nextQuery.value = Object.assign({}, query);
    nextQuery.value = JSON.parse(JSON.stringify(query));

    // 1番目
    query.page = 1;
    // firstQuery.value = Object.assign({}, query);
    firstQuery.value = JSON.parse(JSON.stringify(query));

    // 最後
    query.page = props.lastPage;
    // lastQuery.value = Object.assign({}, query);
    lastQuery.value = JSON.parse(JSON.stringify(query));

    // 中間ページ
    list.value = [];
    getPages().forEach((page) => {
      query.page = page;
      // list.value.push(Object.assign({}, query));
      list.value.push(JSON.parse(JSON.stringify(query)));
    });
  };

  const isFirstPage = computed(() => {
    return props.currentPage === 1;
  });
  const isLastPage = computed(() => {
    return props.currentPage === props.lastPage;
  });
  const isPrevHellip = computed(() => {
    // ページの表示範囲が2より大きい場合
    return props.currentPage - range > 2;
  });
  const isNextHellip = computed(() => {
    // ページの表示範囲が最後のページより小さい場合
    return props.currentPage + range < props.lastPage - 1;
  });

  watch(
    () => props.lastPage,
    () => init()
  );
  watch(
    () => props.currentPage,
    () => init()
  );
  init();
</script>

<template>
  <nav class="pagination is-centered">
    <ul class="pagination-list" :class="{ 'is-marginless': marginless }">
      <li>
        <RouterLink
          v-if="isFirstPage === false"
          :to="{ query: prevQuery }"
          class="button mod-pagination-previous"
          @click="$emit('changePage', prevQuery.page)"
        >
          前へ
        </RouterLink>
      </li>

      <li>
        <RouterLink
          :to="{ query: firstQuery }"
          class="pagination-link"
          :class="{ 'is-current': isFirstPage && lastPage > 1, 'pagination-ellipsis': lastPage < 2 }"
          @click="$emit('changePage', firstQuery.page)"
        >
          1
        </RouterLink>
      </li>
      <li v-if="isPrevHellip"><span class="pagination-ellipsis">&hellip;</span></li>

      <li v-for="query in list" :key="query.page">
        <RouterLink
          :to="{ query: query }"
          class="pagination-link"
          :class="{ 'is-current': currentPage === query.page, 'is-invisible': lastPage < 2 }"
          @click="$emit('changePage', query.page)"
        >
          {{ query.page }}
        </RouterLink>
      </li>

      <li v-if="isNextHellip"><span class="pagination-ellipsis">&hellip;</span></li>
      <li>
        <RouterLink
          :to="{ query: lastQuery }"
          class="pagination-link"
          :class="{ 'is-current': isLastPage, 'is-invisible': lastPage < 2 }"
          @click="$emit('changePage', lastQuery.page)"
        >
          {{ lastPage }}
        </RouterLink>
      </li>
      <li>
        <RouterLink
          v-if="isLastPage === false"
          :to="{ query: nextQuery }"
          class="button mod-pagination-next"
          :class="{ 'is-invisible': lastPage < 2 }"
          @click="$emit('changePage', nextQuery.page)"
        >
          次へ
        </RouterLink>
      </li>
    </ul>
  </nav>
</template>
