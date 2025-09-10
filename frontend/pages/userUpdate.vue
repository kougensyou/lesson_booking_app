<script setup lang="ts">
import { useUserStore } from '~/stores/useUserStore';
import Toast from '~/components/common/toast.vue';
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
      <div>
        <input
          v-model="userStore.user.name"
          class="input border-2 p-2 w-full"
          type="text"
        />
      </div>
    </div>

    <div class="text-sm space-y-6">
      <div class="flex justify-between">
        <span class="font-medium">{{ $t('userUpdate.birthDay') }}</span>
        <input
          v-model="userStore.user.birth_date"
          class="input border-2 p-2 w-full"
          type="text"
        />
      </div>
      <div class="flex justify-between">
        <span class="font-medium">{{ $t('userUpdate.address') }}</span>
        <input
          v-model="userStore.user.zip_code"
          class="input border-2 p-2 w-full"
          type="text"
        />
      </div>
      <div class="text-sm text-right">
        <input
          v-model="userStore.user.address"
          class="input border-2 p-2 w-full"
          type="text"
        />
      </div>
      <div class="flex justify-between">
        <span class="font-medium">{{ $t('userUpdate.telNo') }}</span>
        <input
          v-model="userStore.user.tel_no"
          class="input border-2 p-2 w-full"
          type="text"
        />
      </div>
      <div class="flex justify-between">
        <span class="font-medium">{{ $t('userUpdate.email') }}</span>
        <input
          v-model="userStore.user.email"
          class="input border-2 p-2 w-full"
          type="text"
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
  </div>
  <Toast :show="userStore.toastVisible" :message="userStore.toastMessage" />
</template>
