<script setup>
import Layout from "./components/Layout.vue";
import { useZoneStore } from "./core-logic/store/zoneStore";
import filledColumns from "./core-logic/tests/filledColumnContentWithId.json";
import { onMounted } from "vue";

const zoneStore = useZoneStore();
onMounted(() => zoneStore.$patch({ content: [filledColumns] }));
</script>

<template>
  <Layout />
</template>
