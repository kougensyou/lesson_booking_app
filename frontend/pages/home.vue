<script setup lang="ts">
import { useUserStore } from '../stores/useUserStore';
import { useHomeStore } from '../stores/useHomeStore';
//import { useRouter } from 'vue-router';

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
</template>
