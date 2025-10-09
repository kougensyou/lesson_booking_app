import { defineStore } from 'pinia';
import type { Info, InformationData } from '~/types/information';

export const useInformationStore = defineStore('information', {
  state: () => ({
    isInformationLoading: false as boolean,
    sliderInfoList: [] as Info[],
    gridInfoList: [] as Info[],
    listInfoList: [] as Info[],
  }),
  actions: {
    async getInformationList() {
      this.isInformationLoading = true;
      try {
        const { data, error } = await useSanctumFetch(
          '/api/get_information_list',
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
        const informationData = data.value as InformationData;
        this.sliderInfoList = informationData.slider_info as Info[];
        this.gridInfoList = informationData.grid_info as Info[];
        this.listInfoList = informationData.list_info as Info[];
        this.isInformationLoading = false;
        // console.log('getInformationList:', informationData);
      } catch (err: any) {
        this.isInformationLoading = false;
        console.error('Error getInformationList:', err.data);
        throw err;
      }
    },
  },
});
