<script setup lang="ts">
import { useReportStore } from '../stores/useReportStore';

const reportStore = useReportStore();
</script>
<template>
  <div class="max-w-[640px] mx-auto pl-6 pr-6">
    <h1 class="text-xl font-bold text-center mb-2">
      {{ $t('report.report') }}
    </h1>
    <div>
      <label class="pt-36 pb-2 text-left text-slate-500">{{
        $t('report.reportTitle')
      }}</label>
      <input
        v-model="reportStore.subject"
        type="text"
        class="w-full border rounded px-3 py-2"
      />
    </div>

    <div>
      <label class="pt-36 pb-2 text-left text-slate-500">{{
        $t('report.replyEmail')
      }}</label>
      <input
        v-model="reportStore.email"
        type="email"
        class="w-full border rounded px-3 py-2"
      />
    </div>

    <div>
      <label class="pt-36 pb-2 text-left text-slate-500">{{
        $t('report.reportContent')
      }}</label>
      <textarea
        v-model="reportStore.message"
        rows="5"
        class="w-full border rounded px-3 py-2"
      ></textarea>
    </div>

    <button
      class="mt-12 pt-6 pb-6 pl-3 pr-3 bg-sky-500 rounded-3xl w-full relative group font-loaded"
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
  </div>
</template>
