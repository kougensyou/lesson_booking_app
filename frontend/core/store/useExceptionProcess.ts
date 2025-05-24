import { Ref } from "vue";
import { Router } from "vue-router";

import { errorResponse } from "./useErrorResponse";

/**
 * 例外処理
 * @param {any} err エラーレスポンス
 * @param {boolean} loading True:ローディング表示 False:ローディング非表示
 * @param {Router} router vue-router
 * @param {boolean} isError 任意 True:エラーモーダル表示 False:エラーモーダル非表示
 * @param {object} errors 任意 エラーモーダル表示内容
 **/
export const useExceptionProcess = (err: any, router: Router, isError?: Ref<boolean>, errors?: Ref<object>) => {
  const result = errorResponse(err);

  // エラーレスポンス内容によって画面切り替え
  if (result.html !== undefined) {
    router.push(result.html);
  }

  // 入力チェック等エラーモーダルの表示
  if (typeof isError !== "undefined" && typeof errors !== "undefined") {
    errors.value = result.err;
    isError.value = true;
  }
};
