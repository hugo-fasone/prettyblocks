<template>
  <div class="subfields" :style="`margin-left: calc(${level} * 2.5rem)`">
    <div v-for="field in fields">
      <Repeater v-if="field.type === 'repeater'" :repeater="field" />
      <Component v-else-if="field.type === 'component'" />
      <PrimitiveField v-else />
    </div>
  </div>
</template>

<script setup lang="ts">
import type { FieldContent } from "../../core-logic/entities/ComponentContent";
import Repeater from "./Repeater.vue";

const { fields, level } = defineProps<{
  fields: FieldContent[];
  level: number;
}>();
</script>

<style scoped></style>
