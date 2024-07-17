<template>
  <div class="tree">
    <Block v-for="block in content" :blockContent="block"></Block>
  </div>
</template>

<script setup lang="ts">
import { useZoneStore } from "../../core-logic/store/zoneStore";
import { storeToRefs } from "pinia";
import Block from "./Block.vue";

const zoneStore = useZoneStore();
const { content } = storeToRefs(zoneStore);
</script>

<style scoped>
.tree {
  width: 20rem;
}
</style>
