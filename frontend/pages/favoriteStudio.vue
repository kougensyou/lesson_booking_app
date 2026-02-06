<script setup lang="ts">
import { useStudioStore } from '../stores/useStudioStore';
import { useApiErrorHandler } from '~/composables/useApiErrorHandler';
import { onMounted } from 'vue';
import Toast from '~/components/common/Toast.vue';
import SpinLoading from '~/components/common/SpinLoading.vue';

definePageMeta({
  middleware: 'auth',
});

const router = useRouter();
const studioStore = useStudioStore();
onMounted(() => {
  const addFlag = history.state?.add_flag;
  if (!addFlag) {
    studioStore.setToastMessage();
    studioStore.getFavoriteStudioList().catch((error: any) => {
      useApiErrorHandler(router, error);
    });
  }
});
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('favoriteStudio.tabTitle') }}</title>
    </Head>
  </div>

  <div
    v-if="studioStore.isFavoriteStudioLoading"
    class="fixed inset-0 bg-opacity-50 z-50"
  ></div>

  <div class="p-4">
    <h1 class="text-lg font-bold text-center mb-4">
      {{ $t('favoriteStudio.pageTitle') }}
    </h1>

    <!-- Studio List -->
    <div
      v-for="studio in studioStore.favoriteStudioList"
      :key="studio.id"
      class="flex items-center mb-3"
    >
      <img
        :src="studio.image_url"
        class="w-24 h-16 rounded-lg object-cover mr-3"
      />
      <div class="flex-1">
        <div class="flex items-center">
          <span class="font-semibold">{{ studio.studio_name }}</span>
          <span class="ml-1 text-red-500">❤</span>
        </div>
      </div>
      <span
        class="material-symbols-outlined ml-2 text-red-400 text-xl"
        @click="studioStore.deleteFavoriteStudio(studio.id)"
      >
        do_not_disturb_on
      </span>
    </div>
    <div
      class="border-2 border-dashed rounded-lg py-4 text-center text-gray-500 mb-4"
      @click="$router.push('/studioForFavorite')"
    >
      {{ $t('favoriteStudio.searchStudio') }}
    </div>

    <!-- Save Button -->
    <button
      :class="[
        'w-full py-2 rounded-2xl',
        studioStore.saveButtonActive
          ? 'bg-blue-100 text-blue-600 font-semibold'
          : 'bg-gray-200 text-gray-500 cursor-not-allowed',
      ]"
      @click="studioStore.saveFavoriteStudioList()"
      :disabled="!studioStore.saveButtonActive"
    >
      <span v-if="!studioStore.isFavoriteStudioLoading">{{
        $t('favoriteStudio.save')
      }}</span>
      <span
        v-if="studioStore.isFavoriteStudioLoading"
        class="flex items-center justify-center"
      >
        <SpinLoading :color="'#FFFFFF'" :width="'22px'" :height="'22px'" />
      </span>
    </button>

    <!-- Toast Message -->
    <Toast
      :show="studioStore.toastVisible"
      :message="studioStore.toastMessage"
    />
  </div>
</template>
