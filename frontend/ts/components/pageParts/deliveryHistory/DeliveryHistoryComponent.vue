<script setup lang="ts">
  import { DeliveryHistory } from "../../../types/deliveryHistory";
  import { changeDateFormatFromDate } from "../../../utils/changeDateFormat";
  import { useRouter } from "vue-router";
  //import { numberFormat } from "../../../utils/numberFormat";

  defineProps<{
    totalCount: string;
    loadedPage: number;
    lastPage: number;
    deliveryHistoryList: Array<DeliveryHistory>;
    app: any;
  }>();

  defineEmits(["addDeliveryHistory"]);

  const router = useRouter();

  /**
   * 配送履歴明細画面への遷移
   * @param orderDate
   * @param product_div
   * @param inquiryNo
   */
  const toDeliveryHistoryDetail = (orderDate: string, product_div: string, inquiryNo: string) => {
    router.push({
      name: "deliveryHistoryDetail",
      params: {
        orderDate: orderDate,
        productDiv: product_div,
        inquiryNo: inquiryNo
      }
    });
  };

  /**
   * ファイルアップロード画面への遷移
   * @param orderDate
   * @param productDiv
   * @param inquiryNo
   */
  const toFileUpload = (orderDate: string, productDiv: string, inquiryNo: string) => {
    router.push({
      name: "fileUpload",
      params: {
        orderDate: orderDate,
        productDiv: productDiv,
        inquiryNo: inquiryNo
      }
    });
  };

  /**
   * ファイルアップロード履歴画面への遷移
   */
  const toFileUploadHistory = () => {
    router.push({
      name: "fileUploadHistoryFromHistoryList"
    });
  };
</script>
<template>
  <div v-if="deliveryHistoryList.length > 0">
    <item-count-component :count="totalCount" />

    <div
      v-for="(oneDeliveryHistory, index) in deliveryHistoryList"
      :key="index"
      class="p-2 columns cmp-form-search round-corner shadow is-multiline is-relative"
      @click="
        toDeliveryHistoryDetail(
          oneDeliveryHistory.order_date,
          oneDeliveryHistory.product_div,
          oneDeliveryHistory.inquiry_no
        )
      "
    >
      <span class="material-symbols-outlined orange right_arrow">chevron_right</span>
      <div class="column small is-4 cmp-small-items font-bold">配送完了日時</div>
      <div class="column small is-8 cmp-small-items">
        {{ changeDateFormatFromDate(new Date(oneDeliveryHistory.send_end_date), "yyyy/MM/dd HH:mm") }}
        <div class="right-icon-text">伝票提出</div>
        <div v-if="oneDeliveryHistory.invoice_upload_flag" class="circle small green no-shadow right_icon">
          <span class="material-symbols-outlined too-small">done</span>
        </div>
        <div v-if="!oneDeliveryHistory.invoice_upload_flag" class="circle small light-red no-shadow right_icon">
          <span class="material-symbols-outlined too-small">close</span>
        </div>
      </div>
      <div class="column small is-4 cmp-small-items font-bold">問番</div>
      <div class="column small is-8 cmp-small-items">
        {{ oneDeliveryHistory.product_div ? oneDeliveryHistory.product_div + "-" : ""
        }}{{ oneDeliveryHistory.inquiry_no }}
        <a
          class="ml-5"
          @click.stop="
            toFileUpload(oneDeliveryHistory.order_date, oneDeliveryHistory.product_div, oneDeliveryHistory.inquiry_no)
          "
          >伝票提出</a
        >
        <a v-if="oneDeliveryHistory.invoice_upload_flag" class="ml-5" @click.stop="toFileUploadHistory">伝票確認</a>
      </div>
      <div class="column small is-4 cmp-small-items font-bold">引取先</div>
      <div class="column small is-8 cmp-small-items">
        {{ oneDeliveryHistory.pickup_address }}
      </div>
      <div class="column small is-4 cmp-small-items font-bold">荷届先</div>
      <div class="column small is-8 cmp-small-items">
        {{ oneDeliveryHistory.destination_address }}
      </div>
      <div class="column small is-4 cmp-small-items font-bold">請負額(税込)</div>
      <div class="column small is-8 cmp-small-items"><!-- TODO dummy data -->3,000円</div>
    </div>

    <div v-if="loadedPage < lastPage" class="mt-3 mb-3 level-item">
      <button class="button is-small is-rounded is-primary is-outlined" @click="$emit('addDeliveryHistory')">
        もっとみる
      </button>
    </div>
  </div>
  <div v-if="deliveryHistoryList.length === 0" class="mt-5 level-item">配送履歴はありません。</div>
</template>
<style>
  .right_arrow {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
  }

  .right_icon {
    position: absolute;
    top: 5%;
    right: 20px;
    transform: translateY(-5%);
  }

  .right-icon-text {
    top: 7px;
    position: absolute;
    right: 50px;
  }
</style>
