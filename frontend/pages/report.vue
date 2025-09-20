<script setup lang="ts">
import { useReportStore } from '../stores/useReportStore';
import Toast from '~/components/common/Toast.vue';

const reportStore = useReportStore();
reportStore.initializeReport();
reportStore.setToastMessage();
</script>
<template>
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
    </div>

    <button
      class="mt-12 bg-sky-500 rounded-3xl w-full py-4 relative group font-loaded"
      @click="reportStore.sendReport()"
    >
      <span class="text-white">{{ $t('report.send') }}</span>
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
