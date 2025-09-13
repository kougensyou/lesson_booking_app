<script setup lang="ts">
import type { Studio } from '~/types/studio';
import { useStudioStore } from '../stores/useStudioStore';
import StudioList from '~/components/common/StudioList.vue';

const studioStore = useStudioStore();
await studioStore.getStudioList();
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('lessonBooking.tabTitle') }}</title>
    </Head>
  </div>
  <StudioList
    :studio-list="studioStore.studioList"
    :click-studio-card="
      (studio: Studio) => {
        studioStore.addFavoriteStudio(studio);
        $router.push({
          path: '/favoriteStudio',
          query: { add_flag: true },
        });
      }
    "
  />
</template>
