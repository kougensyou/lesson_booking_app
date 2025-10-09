import type { Composer, UseI18nOptions, VueMessageType } from 'vue-i18n';

export type UseI18nReturnType<Options extends UseI18nOptions = UseI18nOptions> =
  Composer<
    NonNullable<Options['messages']>,
    NonNullable<Options['datetimeFormats']>,
    NonNullable<Options['numberFormats']>,
    Options['locale'] extends unknown ? string : Options['locale']
  >;

export const getI18nArray = (i18n: UseI18nReturnType, key: string): string[] =>
  Object.entries<VueMessageType>(i18n.tm(key)).map(([_, term]) =>
    i18n.rt(term)
  );
