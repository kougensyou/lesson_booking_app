import { ref, Ref } from "vue";
import { DeliveryHistory } from "../types/deliveryHistory";
import { DELIVERYHISTORY } from "../const/const";
import axios from "axios";

export const useDeliveryHistory = () => {
  const deliveryHistoryList: Ref<Array<DeliveryHistory>> = ref([]);
  const loading: Ref<boolean> = ref(false);
  const totalCount: Ref<string> = ref("0");
  const loadedPage: Ref<number> = ref(0);
  const lastPage: Ref<number> = ref(0);
  const masterId: Ref<string> = ref(DELIVERYHISTORY.masterId);
  const isError: Ref<boolean> = ref(false);
  const errors: Ref<object> = ref({});

  /**
   * 配送手配データの取得
   */
  const addDeliveryHistory = () => {
    loading.value = true;
    return axios
      .get("/api/add_delivery_history", {
        params: {
          master_id: masterId.value,
          page: ++loadedPage.value
        }
      })
      .then((res) => {
        deliveryHistoryList.value = deliveryHistoryList.value.concat(res.data.data);
        totalCount.value = res.data.total;
        lastPage.value = res.data.last_page;
      })
      .catch((err: any) => {
        throw err;
      })
      .finally(() => {
        loading.value = false;
      });
  };

  // データ初期化
  const initializeData = () => {
    deliveryHistoryList.value = [];
    loadedPage.value = 0;
  };

  return {
    totalCount,
    loadedPage,
    lastPage,
    deliveryHistoryList,
    loading,
    isError,
    errors,
    addDeliveryHistory,
    initializeData
  };
};
