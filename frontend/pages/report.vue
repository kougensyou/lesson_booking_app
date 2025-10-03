<script setup lang="ts">
import { useReportStore } from '../stores/useReportStore';
import { useApiErrorHandler } from '~/composables/useApiErrorHandler';
import { useRouter } from 'vue-router';
import Toast from '~/components/common/Toast.vue';
import SpinLoading from '~/components/common/SpinLoading.vue';

definePageMeta({
  middleware: 'auth',
});

const router = useRouter();

const reportStore = useReportStore();
reportStore.initializeErrors();
reportStore.initializeReport();
reportStore.setToastMessage();

const sendReport = () => {
  reportStore.sendReportApi().catch((error: any) => {
    useApiErrorHandler(router, error);
  });
};
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('report.tabTitle') }}</title>
    </Head>
  </div>

  <div class="max-w-[640px] mx-auto p-6">
    <h1 class="text-xl font-bold text-center mb-2">
      {{ $t('report.report') }}
    </h1>
    <div class="mb-4">
      <label class="text-left text-slate-500">{{
        $t('report.reportTitle')
      }}</label>
      <input
        v-model="reportStore.title"
        type="text"
        class="w-full border rounded px-3 py-2"
      />
      <template v-for="errorMessage in reportStore.errors?.title">
        <div class="text-red-600 w-full">
          {{ errorMessage }}
        </div>
      </template>
    </div>
    <div class="mb-4">
      <label class="text-left text-slate-500">{{
        $t('report.replyEmail')
      }}</label>
      <input
        v-model="reportStore.email"
        type="email"
        class="w-full border rounded px-3 py-2"
      />
      <template v-for="errorMessage in reportStore.errors?.email">
        <div class="text-red-600 w-full">
          {{ errorMessage }}
        </div>
      </template>
    </div>

    <div class="mb-4">
      <label class="text-left text-slate-500">{{
        $t('report.reportContent')
      }}</label>
      <textarea
        v-model="reportStore.contents"
        rows="5"
        class="w-full border rounded px-3 py-2"
      ></textarea>
      <template v-for="errorMessage in reportStore.errors?.contents">
        <div class="text-red-600 w-full">
          {{ errorMessage }}
        </div>
      </template>
    </div>

    <button
      class="mt-12 bg-sky-500 rounded-3xl w-full py-4 relative group font-loaded"
      @click="sendReport()"
    >
      <span v-if="!reportStore.isReportLoading" class="text-white">{{
        $t('report.send')
      }}</span>
      <span
        v-if="reportStore.isReportLoading"
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
    <Toast
      :show="reportStore.toastVisible"
      :message="reportStore.toastMessage"
    />
  </div>
</template>
