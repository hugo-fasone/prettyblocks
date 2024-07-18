<template>
  <div class="tree">
    <Element
      v-for="block in content"
      :element="block"
      :level="0"
      :children="block.fields"
      :isDeletable="true"
    />
  </div>
</template>

<script setup lang="ts">
import { useZoneStore } from "../../core-logic/store/zoneStore";
import { storeToRefs } from "pinia";
import Element from "./Element.vue";

const zoneStore = useZoneStore();
const { content } = storeToRefs(zoneStore);
</script>

<style scoped>
.tree {
  width: 20rem;
}
</style>
