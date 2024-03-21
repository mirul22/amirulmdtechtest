<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
  setup() {
    return {
      svgPath: '/assets/3DS_corporate-logo_blue.svg'
    };
  }
});
</script>

<template>
    <a href="#" class="flex items-center py-5 px-2 text-gray-700 hover:text-gray-900">
        <img class="h-30 w-30 mr-1 text-blue-400" :src="svgPath" alt="Logo">
    </a>
</template>
