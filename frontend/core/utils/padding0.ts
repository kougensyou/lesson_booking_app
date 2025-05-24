import { ref, Ref } from "vue";

// 文字列の0埋め
export const padding0 = (str: string | number, n: number = 2): string => {
  let addStr: Ref<string> = ref("");
  let s: any = str.toString();
  if (n > s.length) {
    for (let i = 1; i < n; i++) {
      addStr.value += "0";
    }
  }
  return addStr.value + s;
};
