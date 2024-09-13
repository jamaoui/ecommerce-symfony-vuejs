<template>
  <div v-for="data in store.messages" :key="data.message">
    <div
        v-if="data.type === 'success'"
        class="w-100 p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-300"
        role="alert">
      <span class="font-medium" v-text="data.message"></span>
    </div>
  </div>
  <slot></slot>
</template>

<script setup>
import {store} from "../store";

defineProps({
  products: []
});
</script>
