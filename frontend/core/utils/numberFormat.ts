/**
 * 数値フォーマット
 * @param string
 **/
export const numberFormat = (value: string | null): string => {
  if (!value) return "";
  return value.toString().replace(/([0-9]+?)(?=(?:[0-9]{3})+$)/g, "$1,");
};
