<script setup lang="ts">
import { useUserStore } from '~/stores/useUserStore';
import Toast from '~/components/common/Toast.vue';
const userStore = useUserStore();
userStore.setToastMessageForUser();
</script>

<template>
  <div class="px-4 py-3 space-y-6">
    <div class="flex items-center space-x-4">
      <img
        :src="userStore.user.image_url"
        alt="profile"
        class="w-16 h-16 rounded-full"
      />
      <button
        @click="$refs.fileInput.click()"
        class="px-3 py-1 border rounded text-red-500"
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

    <div>
      <label class="block text-sm font-medium">{{
        $t('userUpdate.name')
      }}</label>
      <input
        v-model="userStore.user.name"
        type="text"
        class="mt-1 w-full rounded border p-2"
      />
    </div>

    <div>
      <label class="block text-sm font-medium">{{
        $t('userUpdate.birthDay')
      }}</label>
      <input
        v-model="userStore.user.birth_date"
        type="text"
        class="mt-1 w-full rounded border p-2"
      />
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
    </div>

    <div>
      <label class="block text-sm font-medium">{{
        $t('userUpdate.email')
      }}</label>
      <input
        v-model="userStore.user.email"
        type="text"
        class="mt-1 w-full rounded border p-2"
      />
    </div>

    <button
      class="mt-12 pt-6 pb-6 pl-3 pr-3 bg-sky-500 rounded-3xl w-full relative"
      @click="userStore.updateUser()"
    >
      <span class="text-white">{{ $t('userUpdate.update') }}</span>
      <span
        class="text-white material-symbols-outlined absolute right-3"
        aria-hidden="true"
      >
        chevron_right
      </span>
    </button>
  </div>
  <Toast :show="userStore.toastVisible" :message="userStore.toastMessage" />
</template>
