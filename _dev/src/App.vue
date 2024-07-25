<script setup>
import Layout from "./components/Layout.vue";
import { useZoneStore } from "./core-logic/store/zoneStore";
import filledColumns from "./core-logic/tests/filledColumnContentWithId.json";
import columnStructure from "./core-logic/tests/columnStructure.json";
import { onMounted } from "vue";

const zoneStore = useZoneStore();
onMounted(() =>
  zoneStore.$patch({
    availableBlocks: [columnStructure],
    content: [filledColumns],
  })
);

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
