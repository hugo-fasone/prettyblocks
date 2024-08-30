<script setup>
import Layout from "./components/Layout.vue";
import { useZoneStore } from "./core-logic/store/zoneStore";
import columnStructure from "./core-logic/tests/columnStructure.json";
import allFieldsStructure from "./core-logic/tests/allFieldsStructure.json";
import { onMounted } from "vue";
import { buildNewBlockContentFromBlockStructure } from "./core-logic/utils/builder";

const zoneStore = useZoneStore();
onMounted(() => {
  const columnContent = buildNewBlockContentFromBlockStructure(columnStructure);
  const allFieldsContent =
    buildNewBlockContentFromBlockStructure(allFieldsStructure);
  zoneStore.$patch({
    availableBlocks: [columnStructure, allFieldsStructure],
    content: [columnContent, allFieldsContent],
  });
});

const handleDrag = (dragEvent) => {
  dragEvent.dataTransfer.setDragImage(
    dragEvent.target,
    window.outerWidth,
    window.outerHeight
  );
};

document.addEventListener("dragstart", handleDrag);
</script>

<template>
  <Layout />
</template>
