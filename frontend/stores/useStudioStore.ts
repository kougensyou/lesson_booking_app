import { defineStore } from 'pinia';
import type { FavoriteStudio, Studio } from '~/types/studio';

export const useStudioStore = defineStore('studio', {
  state: () => ({
    favoriteStudioList: [] as FavoriteStudio[],
    studioList: [] as Studio[],
  }),
  actions: {
    async getStudioList() {
      try {
        const { data } = await useSanctumFetch('/api/get_studio_list', {
          method: 'GET',
        });
        this.studioList = data.value as Studio[];
        console.log('studio data fetched:', this.studioList);
      } catch (err) {
        console.error('Error fetching studio data:', err);
      }
    },
    async getFavoriteStudioList() {
      try {
        const { data } = await useSanctumFetch(
          '/api/get_favorite_studio_list',
          {
            method: 'GET',
          }
        );
        this.favoriteStudioList = data.value as FavoriteStudio[];
        console.log('favorite studio data fetched:', this.favoriteStudioList);
      } catch (err) {
        console.error('Error fetching favorite studio data:', err);
      }
    },
  },
});
