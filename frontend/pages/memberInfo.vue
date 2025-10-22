<script setup lang="ts">
import { useSettingStore } from '~/stores/useSettingStore';
import { useUserStore } from '~/stores/useUserStore';
import { useRouter } from 'vue-router';
import SpinLoading from '~/components/common/SpinLoading.vue';

definePageMeta({
  middleware: 'auth',
});

const router = useRouter();
const settingStore = useSettingStore();
const userStore = useUserStore();
settingStore.setSettingList();

const clickSettingArea = (path: string) => {
  if (path === '/logout') {
    userStore.logout();
    return;
  }
  router.push(path);
};
</script>

<template>
  <div class="">
    <Head>
      <title>{{ $t('memberInfo.tabTitle') }}</title>
    </Head>
  </div>

  <div
    v-if="userStore.isUserLoading"
    class="fixed inset-0 bg-opacity-50 z-50"
  ></div>

  <!-- User Information -->
  <div class="px-4 py-3 space-y-6">
    <div class="flex items-center space-x-4">
      <img
        :src="userStore.user.image_url"
        alt="profile"
        class="w-16 h-16 rounded-full"
      />
      <div>
        <p class="font-bold text-lg">{{ userStore.user.name }}</p>
      </div>
    </div>

    <div class="text-sm space-y-6">
      <div class="flex justify-between">
        <span class="font-medium">{{ $t('memberInfo.birthDay') }}</span>
        <span>{{ userStore.user.birth_date }}</span>
      </div>
      <div class="flex justify-between">
        <span class="font-medium">{{ $t('memberInfo.address') }}</span>
        <span>{{ userStore.user.zip_code }}</span>
      </div>
      <div class="text-sm text-right">
        {{ userStore.user.address }}
      </div>
      <div class="flex justify-between">
        <span class="font-medium">{{ $t('memberInfo.telNo') }}</span>
        <span>{{ userStore.user.tel_no }}</span>
      </div>
      <div class="flex justify-between">
        <span class="font-medium">{{ $t('memberInfo.email') }}</span>
        <span>{{ userStore.user.email }}</span>
      </div>
      <button
        class="mt-12 bg-sky-500 rounded-3xl w-full py-4 relative"
        @click="$router.push('/userUpdate')"
      >
        <span class="text-white">{{ $t('memberInfo.userUpdate') }}</span>
        <span
          class="text-white material-symbols-outlined absolute right-3"
          aria-hidden="true"
        >
          chevron_right
        </span>
      </button>
    </div>
  </div>

  <!-- Settings -->
  <div
    v-for="setting in settingStore.settingList"
    class="px-4 py-3 border-b border-gray-100 relative"
    @click="clickSettingArea(setting.path)"
  >
    <a rel="noopener noreferrer" class="text-gray-800">
      {{ setting.setting_name }}
    </a>
    <span
      v-if="userStore.isUserLoading && setting.path === '/logout'"
      class="absolute right-3"
    >
      <SpinLoading :color="'#99a1ae'" :width="'22px'" :height="'22px'" />
    </span>
    <span
      v-if="!userStore.isUserLoading && setting.path === '/logout'"
      class="text-gray-400 material-symbols-outlined absolute right-3"
    >
      chevron_right
    </span>
    <span
      v-if="setting.path !== '/logout'"
      class="text-gray-400 material-symbols-outlined absolute right-3"
    >
      chevron_right
    </span>
  </div>
</template>
