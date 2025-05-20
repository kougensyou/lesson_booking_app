import { ref, Ref } from "vue";

/**
 * エラー画面表示、エラーモーダル内容取得
 * @param {any} error エラーレスポンス
 * @return エラーhtml・エラー内容
 **/
export const errorResponse = (error: any) => {
  let html: Ref<string | undefined> = ref(undefined);
  let err: Ref<any> = ref(null);
  // Laravel側のエラー画面 resources/views/errors/

  if (error.response) {
    if (error.response.status == 401) {
      html.value = "/401";
    } else if (error.response.status == 403) {
      html.value = "/403";
    } else if (error.response.status == 404) {
      html.value = "/404";
    } else if (error.response.status == 500) {
      html.value = "/500";
    } else if (error.response.status == 502) {
      html.value = "/502";
    }

    // エラーレスポンスを返す
    else if (error.response.status == 422) {
      if (error.response.data.errors) {
        err.value = error.response.data.errors;
      }
    }

    // その他のエラー表示
    else if (error.response.data.errors) {
      err.value = error.response.data.errors;
    }
  } else if (error.request) {
    console.log(error.request);
    html.value = "/500";
  } else {
    console.log("Error", error.message);
    html.value = "/500";
  }

  // 結果をセット
  const result = ref({
    html: html.value,
    err: err.value
  });

  return result.value;
};
