<script setup lang="ts">
import type { Studio } from '~/types/studio';
import { useStudioStore } from '../stores/useStudioStore';
import StudioList from '~/components/common/StudioList.vue';

const studioStore = useStudioStore();
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
        $router.push({
          path: '/studioLesson',
          query: { studio_id: studio.id },
        });
      }
    "
  />
</template>
