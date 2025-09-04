<script setup lang="ts">
import type { Studio } from '~/types/studio';
import { useStudioStore } from '../stores/useStudioStore';
import studioList from '~/components/common/studioList.vue';

const studioStore = useStudioStore();
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('lessonBooking.tabTitle') }}</title>
    </Head>
  </div>
  <studioList
    :studioList="studioStore.studioList"
    :clickStudioCard="
      (studio: Studio) => {
        $router.push({
          path: '/studioLesson',
          query: { studio_id: studio.id },
        });
      }
    "
  />
</template>
