import { defineStore } from 'pinia';
import type { Info, InformationData } from '~/types/information';

export const useInformationStore = defineStore('information', {
  state: () => ({
    sliderInfoList: [] as Info[],
    gridInfoList: [] as Info[],
    listInfoList: [] as Info[],
  }),
  actions: {
    async getInformationList() {
      try {
        const { data } = await useSanctumFetch('/api/get_information_list', {
          method: 'GET',
        });
        const informationData = data.value as InformationData;
        this.sliderInfoList = informationData.slider_info as Info[];
        this.gridInfoList = informationData.grid_info as Info[];
        this.listInfoList = informationData.list_info as Info[];
        console.log('information data fetched:', informationData);
      } catch (err) {
        console.error('Error fetching information list:', err);
      }
    },
  },
});
