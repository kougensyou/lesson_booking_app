<script setup lang="ts">
  import { getCurrentInstance, ref, Ref, watch } from "vue";
  import { DIALOG_MESSAGE } from "../utils/messages";
  const props = withDefaults(
    defineProps<{
      // ダイアログ表示判定
      show: boolean;
      deleteButton?: boolean;
      // ダイアログより後ろのコンテンツの操作制御
      pointerEvent?: boolean;
      // 自動非表示
      autoHidden?: boolean;
      // 表示時間
      displayTime?: number;
      // ダイアログの色
      // primary エメラルド
      // info    青
      // success 緑
      // warning 黄色
      // danger  赤
      dialogType?: string;
      // ヘッダーテキスト
      headerText?: string;
      // 実行ボタンテキスト
      submitText?: string;
      // 閉じるボタンテキスト
      closeText?: string;
      // 固定メッセージ
      // メッセージIDが設定されている場合は固定メッセージの表示を優先
      messageId?: string;
      // 固定メッセージの対象
      messageTarget?: Array<string>;
      isMedium: boolean;
    }>(),
    {
      deleteButton: true,
      pointerEvent: false,
      autoHidden: true,
      displayTime: 10000,
      dialogType: undefined,
      headerText: undefined,
      submitText: undefined,
      closeText: undefined,
      messageId: undefined,
      messageTarget: undefined,
      isMedium: false
    }
  );

  defineEmits(["closed", "submit"]);

  const self = getCurrentInstance()!.proxy;

  // メッセージの種類
  let messageType: Ref<any> = ref({
    primary: "is-primary",
    info: "is-info",
    success: "is-success",
    warning: "is-warning",
    danger: "is-danger"
  });
  let type = ref(null);
  let header: Ref<string> = ref("");
  // setTimeoutの処理停止ID
  let timeoutId: number | undefined = undefined;
  let messageText = ref("");

  const closed = () => {
    // setTimeoutの処理が重複しないようにする
    clearTimeout(timeoutId);
    self!.$emit("closed");
  };

  // メッセージの更新関数
  const updateMessageText = () => {
    // 固定メッセージの設定
    if (props.messageId) {
      if (!DIALOG_MESSAGE[props.messageId]) {
        console.log("Message id not found.");
        throw "Message id not found.";
      }

      // メッセージの種類を設定
      if (props.messageId.match(/^I/)) {
        header.value = "Success";
        type.value = messageType.value["success"];
      } else if (props.messageId.match(/^W/)) {
        header.value = "Warning";
        type.value = messageType.value["warning"];
      } else if (props.messageId.match(/^E/)) {
        header.value = "Error";
        type.value = messageType.value["danger"];
      }

      // メッセージの設定
      if (props.messageTarget === undefined) {
        messageText.value = `${DIALOG_MESSAGE[props.messageId]}`;
      } else {
        messageText.value = "";
        for (const target of props.messageTarget) {
          if (messageText.value == "") {
            messageText.value = DIALOG_MESSAGE[props.messageId].replace("{}", target);
          } else {
            messageText.value = messageText.value.replace("{}", target);
          }
        }
      }
    }
  };

  // 表示設定
  watch(
    () => props.show,
    (newValue) => {
      if (newValue === false) {
        return;
      }
      // ダイアログの色を設定
      if (props.dialogType !== undefined && messageType.value[props.dialogType]) {
        type.value = messageType.value[props.dialogType];
      }

      updateMessageText();

      if (props.headerText) {
        header.value = props.headerText;
      } else {
        // ダイアログタイプの設定
        if (header.value === "") {
          switch (props.dialogType) {
            case "info":
              header.value = "Info";
              break;
            case "success":
              header.value = "Success";
              break;
            case "warning":
              header.value = "Warning";
              break;
            case "error":
              header.value = "Error";
              break;
            default:
              header.value = "Message";
              break;
          }
        }
      }

      // 自動非表示設定
      if (props.autoHidden === false) {
        return;
      }

      timeoutId = setTimeout(closed, props.displayTime);
    }
  );

  // props.messageTargetが変更されたときにメッセージを更新する
  // messageTargetの内容がユーザー操作やその他のイベントで、
  // 動的に変更される場合にメッセージを更新する
  watch(
    () => props.messageTarget,
    () => {
      updateMessageText();
    },
    { deep: true }
  );

  let size: Ref<string> = ref("");

  if (props.isMedium) {
    size.value = "80%";
  }
</script>

<template>
  <div v-if="show" class="modal is-active" :class="{ 'utl-is-event-none': pointerEvent }">
    <div class="modal-content" :style="{ width: size }">
      <div class="message" :class="type">
        <!-- ヘッダー -->
        <div class="message-header">
          <p>{{ header }}</p>
          <button v-if="deleteButton" class="delete" @click="closed"></button>
        </div>
        <div class="message-body">
          <div class="utl-text">
            <!-- 定義メッセージ -->
            <slot v-if="!messageId" name="content"></slot>
            <!-- 固定メッセージ -->
            <template v-else>{{ messageText }}</template>
          </div>
          <!-- ボタン -->
          <div v-if="submitText || closeText" class="field is-grouped is-grouped-right utl-mt10">
            <div v-if="submitText" class="control">
              <button class="button is-small is-primary utl-plr20" @click="$emit('submit')">
                {{ submitText }}
              </button>
            </div>
            <div v-if="closeText" class="control">
              <button class="button is-small is-primary is-outlined utl-plr20" @click="closed">
                {{ closeText }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
