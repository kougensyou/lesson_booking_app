import { format, parse } from "date-fns";

/**
 * 日付フォーマット
 * @param {string} value yyyyMMdd or yyyyMMdd:HH:mm:ss
 **/
export const changeDateFormat = (value: string) => {
  if (!value) {
    return "";
  }
  let dateFormat: string = "";
  if (value.match(":")) {
    dateFormat = "yyyy/M/d HH:mm:ss";
  } else {
    dateFormat = "yyyy/M/d";
  }
  const date = parse(value, "yyyyMMdd", new Date());
  return format(date, dateFormat);
};

/**
 * 日付フォーマット
 * @param {Date} date
 * @param {string} dateFormat
 **/
export const changeDateFormatFromDate = (date: Date, dateFormat: string) => {
  return format(date, dateFormat);
};

export const getNowDateFormatted = (dateFormat: string) => {
  return format(new Date(), dateFormat);
};
