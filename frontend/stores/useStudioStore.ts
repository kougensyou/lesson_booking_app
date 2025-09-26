import { defineStore } from 'pinia';
import type { Studio } from '~/types/studio';
import { useI18n } from 'vue-i18n';

export const useStudioStore = defineStore('studio', {
  state: () => ({
    initialFavoriteStudioList: [] as Studio[],
    isFavoriteStudioLoading: false as boolean,
    favoriteStudioList: [] as Studio[],
    isStudioLoading: false as boolean,
    studioList: [] as Studio[],
    saveButtonActive: false as boolean,
    toastMessage: '' as string,
    toastVisible: false as boolean,
    toastTimeout: 0 as number,
  }),
  actions: {
    setToastMessage() {
      const { t } = useI18n();
      this.toastMessage = t('favoriteStudio.toastMessage');
    },
    async getStudioList() {
      this.isStudioLoading = true;
      try {
        const { data, error } = await useSanctumFetch('/api/get_studio_list', {
          method: 'GET',
        });
        if (error.value) {
          throw createError({
            statusCode: error.value.statusCode,
            message: error.value.message,
            data: error.value.data,
          });
        }
        this.studioList = data.value as Studio[];
        this.isStudioLoading = false;
        console.log('studio data fetched:', this.studioList);
      } catch (err: any) {
        this.isStudioLoading = false;
        console.error('Error fetching studio data:', err.data);
        throw err;
      }
    },
    async getFavoriteStudioList() {
      this.isFavoriteStudioLoading = true;
      try {
        const { data, error } = await useSanctumFetch(
          '/api/get_favorite_studio_list',
          {
            method: 'GET',
          }
        );
        if (error.value) {
          throw createError({
            statusCode: error.value.statusCode,
            message: error.value.message,
            data: error.value.data,
          });
        }
        this.initialFavoriteStudioList = data.value as Studio[];
        this.favoriteStudioList = data.value as Studio[];
        this.isFavoriteStudioLoading = false;
        console.log('favorite studio data fetched:', this.favoriteStudioList);
      } catch (err: any) {
        this.isFavoriteStudioLoading = false;
        console.error('Error fetching favorite studio data:', err.data);
        throw err;
      }
    },
    async saveFavoriteStudioList() {
      try {
        const { data, error } = await useSanctumFetch(
          '/api/save_favorite_studio_list',
          {
            method: 'POST',
            body: {
              initial_favorite_studio_list: this.initialFavoriteStudioList,
              favorite_studio_list: this.favoriteStudioList,
            },
          }
        );
        if (error.value) {
          throw createError({
            statusCode: error.value.statusCode,
            message: error.value.message,
            data: error.value.data,
          });
        }
        console.log('saveFavoriteStudioList fetched:', data.value);
        this.saveButtonActive = false;
        this.openToast(2500);
      } catch (err: any) {
        console.error('Error fetching saveFavoriteStudioList data:', err.data);
        throw err;
      }
    },
    deleteFavoriteStudio(studioId: number) {
      this.favoriteStudioList = this.favoriteStudioList.filter(
        (studio) => studio.id !== studioId
      );
      this.saveButtonActive = true;
    },
    addFavoriteStudio(studio: Studio) {
      if (!this.favoriteStudioList.some((s) => s.id === studio.id)) {
        this.favoriteStudioList = [...this.favoriteStudioList, studio];
      }
      this.saveButtonActive = true;
    },
    openToast(ms = 2500) {
      this.toastVisible = true;
      clearTimeout(this.toastTimeout);
      this.toastTimeout = window.setTimeout(
        () => (this.toastVisible = false),
        ms
      );
    },
  },
});
