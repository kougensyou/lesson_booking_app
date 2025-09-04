import { defineStore } from 'pinia';
import type { Setting } from '~/types/setting';
import { useI18n } from 'vue-i18n';

export const useSettingStore = defineStore('setting', {
  state: () => ({
    settingList: [] as Setting[],
  }),
  actions: {
    setSettingList() {
      const { t } = useI18n();
      this.settingList = [
        {
          path: '/favoriteStudio',
          setting_name: t('memberInfo.favoriteStudio'),
        },
        {
          path: '/report',
          setting_name: t('memberInfo.report'),
        },
        {
          path: '/passwordChange',
          setting_name: t('memberInfo.passwordChange'),
        },
        {
          path: '/logout',
          setting_name: t('memberInfo.logout'),
        },
      ];
    },
  },
});
