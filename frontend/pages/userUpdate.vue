<script setup lang="ts">
import { useUserStore } from '~/stores/useUserStore';
import { useApiErrorHandler } from '~/composables/useApiErrorHandler';
import { useRouter } from 'vue-router';
import Toast from '~/components/common/Toast.vue';
import SpinLoading from '~/components/common/SpinLoading.vue';

definePageMeta({
  middleware: 'auth',
});

const router = useRouter();

const userStore = useUserStore();
userStore.initializeErrors();
userStore.setToastMessageForUser();

const updateUser = () => {
  userStore.updateUserApi().catch((error: any) => {
    useApiErrorHandler(router, error);
  });
};
</script>

<template>
  <div class="">
    <Head>
      <title>{{ $t('userUpdate.tabTitle') }}</title>
    </Head>
  </div>

  <div
    v-if="userStore.isUserLoading"
    class="fixed inset-0 bg-opacity-50 z-50"
  ></div>

  <div class="px-4 py-3 space-y-6">
    <!-- Image -->
    <div class="flex items-center space-x-4">
      <img
        :src="userStore.user.image_url"
        alt="profile"
        class="w-16 h-16 rounded-full"
      />
      <button
        @click="$refs.fileInput.click()"
        class="px-3 py-1 border border-red-500 rounded text-red-500 bg-transparent"
      >
        {{ $t('userUpdate.selectImage') }}
      </button>
      <input
        ref="fileInput"
        type="file"
        accept="image/*"
        capture="environment"
        class="hidden"
        @change="userStore.onFileChange"
      />
    </div>
    <template v-for="errorMessage in userStore.errors?.image_url">
      <div class="text-red-600 w-full">
        {{ errorMessage }}
      </div>
    </template>

    <!-- Input Form -->

    <div>
      <label class="block text-sm font-medium">{{
        $t('userUpdate.name')
      }}</label>
      <input
        v-model="userStore.user.name"
        type="text"
        class="mt-1 w-full rounded border p-2"
      />
      <template v-for="errorMessage in userStore.errors?.name">
        <div class="text-red-600 w-full">
          {{ errorMessage }}
        </div>
      </template>
    </div>

    <div>
      <label class="block text-sm font-medium">{{
        $t('userUpdate.birthDay')
      }}</label>
      <input
        v-model="userStore.user.birth_date"
        type="date"
        class="mt-1 w-full rounded border p-2"
      />
      <template v-for="errorMessage in userStore.errors?.birth_date">
        <div class="text-red-600 w-full">
          {{ errorMessage }}
        </div>
      </template>
    </div>

    <div>
      <label class="block text-sm font-medium">{{
        $t('userUpdate.zipCode')
      }}</label>
      <input
        v-model="userStore.user.zip_code"
        type="text"
        class="mt-1 w-full rounded border p-2"
      />
      <template v-for="errorMessage in userStore.errors?.zip_code">
        <div class="text-red-600 w-full">
          {{ errorMessage }}
        </div>
      </template>
    </div>

    <div>
      <label class="block text-sm font-medium">{{
        $t('userUpdate.address')
      }}</label>
      <input
        v-model="userStore.user.address"
        type="text"
        class="mt-1 w-full rounded border p-2"
      />
      <template v-for="errorMessage in userStore.errors?.address">
        <div class="text-red-600 w-full">
          {{ errorMessage }}
        </div>
      </template>
    </div>

    <div>
      <label class="block text-sm font-medium">{{
        $t('userUpdate.telNo')
      }}</label>
      <input
        v-model="userStore.user.tel_no"
        type="text"
        class="mt-1 w-full rounded border p-2"
      />
      <template v-for="errorMessage in userStore.errors?.tel_no">
        <div class="text-red-600 w-full">
          {{ errorMessage }}
        </div>
      </template>
    </div>

    <div>
      <label class="block text-sm font-medium">{{
        $t('userUpdate.email')
      }}</label>
      {{ userStore.user.email }}
      <template v-for="errorMessage in userStore.errors?.email">
        <div class="text-red-600 w-full">
          {{ errorMessage }}
        </div>
      </template>
    </div>

    <!-- Update Button -->
    <button
      class="mt-12 bg-sky-500 rounded-3xl w-full py-4 relative"
      @click="updateUser()"
    >
      <span v-if="!userStore.isUserLoading" class="text-white">{{
        $t('userUpdate.update')
      }}</span>
      <span
        v-if="userStore.isUserLoading"
        class="flex items-center justify-center"
      >
        <SpinLoading :color="'#FFFFFF'" :width="'22px'" :height="'22px'" />
      </span>
      <span
        class="text-white material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2"
        aria-hidden="true"
      >
        chevron_right
      </span>
    </button>
  </div>

  <!-- Toast Message -->
  <Toast :show="userStore.toastVisible" :message="userStore.toastMessage" />
</template>
