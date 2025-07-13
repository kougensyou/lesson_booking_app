<script setup lang="ts">
import { useUserStore } from '../stores/useUserStore';
import { useHomeStore } from '../stores/useHomeStore';
import HorizontalScroll from '../components/horizontalScroll.vue';
//import { useRouter } from 'vue-router';

debugger;

//const router = useRouter();
const user = useUserStore();
const { tokenData } = user;
const homeStore = useHomeStore();

await homeStore.getHomeData(tokenData.access_token);
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('home.tabTitle') }}</title>
    </Head>
  </div>
  <HorizontalScroll>
    <div
      v-for="i in 6"
      :key="i"
      class="min-w-[250px] h-[150px] bg-blue-100 rounded-xl shadow flex items-center justify-center shrink-0"
    >
      カード {{ i }}
    </div>
  </HorizontalScroll>
</template>
