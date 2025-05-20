/**
 * 外部スクリプト読み込み
 * @param string or array source
 **/
export const scriptLoader = (id: string, src: string) => {
  let element = document.createElement("script");
  element.setAttribute("id", id);
  element.setAttribute("src", src);
  document.head.appendChild(element);
};
