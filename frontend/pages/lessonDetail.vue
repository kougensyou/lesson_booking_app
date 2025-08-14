<script setup lang="ts">
import { useLessonDetailStore } from '../stores/useLessonDetailStore';
import { useRoute } from 'vue-router';

const route = useRoute();

const lessonDetailStore = useLessonDetailStore();

const lessonId = route.query.lesson_id as string;

lessonDetailStore.setLessonId(lessonId);
await lessonDetailStore.getLessonDetailApi();
</script>
<template>
  <div class="">
    <Head>
      <title>{{ $t('lessonDetail.tabTitle') }}</title>
    </Head>
  </div>
  <div class="bg-white min-h-screen p-4 space-y-4 max-w-xl mx-auto">
    <h1 class="text-xl font-bold">マジックサークル 〜コアを安定させる〜</h1>
    <div class="text-gray-600 text-sm">Aoi.W</div>
    <div class="text-sm text-gray-700">日吉　08/14（木）20:00 - 20:55</div>

    <img src="" alt="マジックサークル" class="w-full rounded" />

    <div class="text-sm space-y-2 leading-relaxed">
      <p>※このレッスンはマジックサークルを使用します。</p>
      <p>
        マジックサークルの抵抗を利用して、体幹を支える背骨付近のインナーマッスルを目覚めさせます。
      </p>
      <p>呼吸と動きのつながりや、四肢と体幹のつながりを学べるクラスです。</p>
    </div>

    <div class="flex items-center space-x-4 mt-4">
      <img src="" alt="Aoi.W" class="w-14 h-14 rounded-full object-cover" />
      <div>
        <div class="font-semibold">Aoi.W</div>
        <div class="text-sm text-gray-500">神奈川県綾瀬市で育ちました。</div>
      </div>
    </div>

    <div class="fixed bottom-0 left-0 right-0 bg-white px-4 py-4">
      <div class="max-w-md mx-auto">
        <button
          class="w-full bg-sky-500 text-white rounded-3xl py-4 relative"
          @click="searchLessons"
        >
          <span>{{ $t('lessonDetail.bookButton') }}</span>
        </button>
        <div class="text-center text-sm text-blue-600 underline cursor-pointer">
          {{ $t('lessonDetail.backButton') }}
        </div>
      </div>
    </div>
  </div>
</template>
