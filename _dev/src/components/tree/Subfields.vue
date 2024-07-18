<template>
  <div class="subfields" :style="`margin-left: 1.5rem`">
    <div v-for="field in fields">
      <Element
        :element="field"
        :level="level + 1"
        :children="getChildrenFromElement(field)"
        :isDeletable="deletableChildren"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
import type { FieldContent } from "../../core-logic/entities/ComponentContent";
import Element from "./Element.vue";

const { fields, level, deletableChildren } = defineProps<{
  fields: FieldContent[];
  level: number;
  deletableChildren: boolean;
}>();

const getChildrenFromElement = (element) => {
  if (element.type === "repeater") return element.sub_elements;
  if (element.type === "component") return element.fields;
  return [];
};
</script>

<style scoped></style>
