import { GeneralInterface } from "../interface/CommonInterface";

/**
 * オブジェクト型の配列をソートするためのクロージャを返す
 * @param Array ArrayObj //ソートしたいオブジェクト形式の配列
 * @param Array list //ソート項目をJson形式の配列で指定 example: list = [{key: "search_index", reverse: false}, {...} ] reverse:false -> 昇順 reverse:true -> 降順
 * @return function
 **/
export const ArrayobjectSort = (ArrayObj: GeneralInterface, list: { key: string; reverse: boolean }[]) => {
  ArrayObj.sort(function (a: any, b: any) {
    for (let i = 0; i < list.length; i++) {
      const order_by = list[i].reverse ? 1 : -1;
      return a[list[i].key] < b[list[i].key] ? order_by : order_by * -1;
    }
  });
};
