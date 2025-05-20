<script setup lang="ts">
  import { useDeliveryHistory } from "../../hooks/useDeliveryHistory";
  import { useRouter } from "vue-router";
  import { useExceptionProcess } from "../../hooks/useExceptionProcess";

  defineProps<{
    app: any;
  }>();

  const router = useRouter();

  const {
    totalCount,
    loadedPage,
    lastPage,
    deliveryHistoryList,
    isError,
    errors,
    loading,
    addDeliveryHistory,
    initializeData
  } = useDeliveryHistory();

  // データの再表示
  const updateDeliveryHistory = () => {
    initializeData();
    addDeliveryHistory().catch((error: any) => {
      useExceptionProcess(error, router, isError, errors);
    });
  };

  addDeliveryHistory().catch((error: any) => {
    useExceptionProcess(error, router, isError, errors);
  });
</script>

<template>
  <!-- <HeaderComponent :app="{ user, common }" /> -->
  <div class="m-1 is-flex">
    <BreadcrumbComponent :app="app" />
    <div class="absolute-right">
      <execution-button-component text="再表示" :size="'small'" @click="updateDeliveryHistory" />
    </div>
  </div>

  <div class="m-2">
    <delivery-history-component
      :total-count="totalCount"
      :loaded-page="loadedPage"
      :last-page="lastPage"
      :delivery-history-list="deliveryHistoryList"
      @add-delivery-history="addDeliveryHistory"
    />
  </div>

  <loading-component :show="loading" />
</template>
