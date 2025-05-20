<script setup lang="ts">
  defineProps<{
    type: string;
    tab: Array<{
      key: string;
      name: string;
    }>;
  }>();

  defineEmits(["changeFocus"]);
</script>

<template>
  <div class="tabs is-toggle is-small utl-m10">
    <ul>
      <li v-for="item in tab" :key="item.key" :class="{ 'is-active': type === item.key }">
        <a @click="$emit('changeFocus', item.key)">
          <span>{{ item.name }}</span>
        </a>
      </li>
    </ul>
  </div>
</template>
