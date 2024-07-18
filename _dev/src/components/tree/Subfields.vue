<template>
  <div class="subfields" :style="`margin-left: 1.5rem`">
    <div v-for="field in fields">
      <Element
        :element="field"
        :children="getChildrenFromElement(field)"
        :isDeletable="parentElement.type === 'repeater'"
      />
    </div>
    <div
      v-if="parentElement.type === 'repeater'"
      class="subfieldAdd"
      @click="addNewElement"
    >
      <Icon name="PlusIcon" />
      Ajouter un élément {{ parentElement.label }}
    </div>
  </div>
</template>

<script setup lang="ts">
import type {
  ComponentContent,
  FieldContent,
} from "../../core-logic/entities/ComponentContent";
import type { BlockContent } from "../../core-logic/entities/BlockContent";
import Element from "./Element.vue";
import Icon from "../Icon.vue";
import { useZoneStore } from "../../core-logic/store/zoneStore";
import { PrimitiveFieldContent } from "../../core-logic/entities/PrimitiveFieldContent";
import { PrimitiveFieldType } from "../../core-logic/entities/ElementType";
import { Repeater } from "../../core-logic/entities/Repeater";
import { findComponentBlock } from "../../core-logic/utils/finder";

const { fields, parentElement } = defineProps<{
  fields: FieldContent[];
  parentElement: FieldContent | BlockContent;
}>();

const zoneStore = useZoneStore();

const getChildrenFromElement = (element) => {
  if (element.type === "repeater") return element.sub_elements;
  if (element.type === "component") return element.fields;
  return [];
};

const addNewElement = () => {
  const blockId = findComponentBlock(zoneStore.content, parentElement.id).id;
  const componentId = (
    parentElement as Repeater<
      ComponentContent | PrimitiveFieldContent<PrimitiveFieldType>
    >
  ).sub_element_id;
  console.log(blockId, parentElement.id, componentId);
  zoneStore.addComponent(blockId, parentElement.id, componentId);
};
</script>

<style scoped>
.subfieldAdd {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}
</style>
