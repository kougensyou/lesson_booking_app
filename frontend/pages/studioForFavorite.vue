<script setup lang="ts">
import type { Studio } from '~/types/studio';
import { useStudioStore } from '../stores/useStudioStore';
import { useApiErrorHandler } from '~/composables/useApiErrorHandler';
import { useRouter } from 'vue-router';
import StudioList from '~/components/common/StudioList.vue';
import SpinLoading from '~/components/common/SpinLoading.vue';

definePageMeta({
  middleware: 'auth',
});

const router = useRouter();

const studioStore = useStudioStore();
studioStore.getStudioList().catch((error: any) => {
  useApiErrorHandler(router, error);
});
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('lessonBooking.tabTitle') }}</title>
    </Head>
  </div>

  <div
    v-if="studioStore.isStudioLoading"
    class="fixed inset-0 bg-opacity-50 z-50"
  ></div>

  <div
    v-if="studioStore.isStudioLoading"
    class="fixed inset-0 flex items-center justify-center"
  >
    <SpinLoading />
  </div>

  <StudioList
    v-if="!studioStore.isStudioLoading"
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
