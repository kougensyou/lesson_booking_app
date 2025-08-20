<script setup lang="ts">
const user = {
  memberId: '100065786',
  name: 'テスト',
  nameKana: 'テスト',
  birth: '1995-01-01',
  address: '神奈川県横浜市港北区',
  zip: '223-1111',
  phone: '080-1111-1111',
};
</script>

<template>
  <div class="max-w-md mx-auto bg-white shadow rounded-lg p-6 space-y-6">
    <div class="flex items-center space-x-4">
      <img src="" alt="profile" class="w-16 h-16 rounded-full" />
      <div>
        <p class="font-bold text-lg">{{ user.name }}</p>
        <p class="text-sm text-gray-500">{{ user.nameKana }}</p>
      </div>
    </div>

    <div class="text-sm space-y-4">
      <div class="flex justify-between">
        <span class="font-medium">会員番号:</span>
        <span>{{ user.memberId }}</span>
      </div>
      <div class="flex justify-between">
        <span class="font-medium">生年月日:</span>
        <span>{{ user.birth }}</span>
      </div>
      <div class="flex justify-between">
        <span class="font-medium">住所:</span>
        <span>{{ user.zip }}</span>
      </div>
      <div class="text-sm text-right">
        {{ user.address }}
      </div>
      <div class="flex justify-between">
        <span class="font-medium">電話番号:</span>
        <span>{{ user.phone }}</span>
      </div>
    </div>
  </div>
</template>
