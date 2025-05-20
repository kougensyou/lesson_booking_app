import { ref } from "vue";
import { saveAs } from "file-saver";

/**
 * axiosリクエストしたBLOBファイルをブラウザにダウンロード
 * @param Response res       //blob指定でサーバから受け取ったレスポンスデータ
 * @param String   filename  //ファイル名を直接指定したい場合
 **/
export const downloadBlobFile = (res: any, filename: string = ""): void => {
  const contentType = res.data.type;
  const blob = new Blob([res.data], { type: contentType });
  let saveFileName = ref("");
  if (!filename) {
    const contentDisposition: string = res.headers["content-disposition"];
    saveFileName.value = getFileName(contentDisposition);
  } else {
    saveFileName.value = filename;
  }
  saveAs(blob, saveFileName.value);
};

const getFileName = (contentDisposition: string): string => {
  const fileNameIndex = contentDisposition.indexOf("filename=") + 9;

  const fileName = contentDisposition.substring(fileNameIndex, contentDisposition.length);

  return fileName;
};
