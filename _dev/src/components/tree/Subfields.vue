<template>
  <div class="subfields">
    <div class="subfieldDraggableZone" :class="lastMoveEvent ? 'dragging' : ''">
      <draggable
        :list="fields"
        :group="parentElement.id"
        item-key="id"
        :move="handleMove"
        @end="handleDrop"
      >
        <template #item="{ element }">
          <Element
            :element="element"
            :children="getChildrenFromElement(element)"
            :isDeletable="parentElement.type === 'repeater'"
            :isMovable="parentElement.type === 'repeater'"
            class="tree-element"
          />
        </template>
      </draggable>
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
import { ref } from "vue";
import draggable from "vuedraggable";

const { fields, parentElement } = defineProps<{
  fields: FieldContent[];
  parentElement: FieldContent | BlockContent;
}>();

const zoneStore = useZoneStore();
const lastMoveEvent = ref(null);

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
  ).component_id;
  zoneStore.addComponent(blockId, parentElement.id, componentId);
};

const handleMove = (moveEvent) => {
  if (parentElement.type !== "repeater") return false;
  lastMoveEvent.value = moveEvent;
  document
    .querySelectorAll(".tree-element")
    .forEach((treeElement) =>
      treeElement.classList.remove("place-after", "place-before")
    );
  moveEvent.related.classList.add(
    moveEvent.willInsertAfter ? "place-after" : "place-before"
  );
  // Return false to prevent default behavior
  return false;
};

const handleDrop = () => {
  document
    .querySelectorAll(".tree-element")
    .forEach((treeElement) =>
      treeElement.classList.remove("place-after", "place-before")
    );
  if (!lastMoveEvent.value) return;
  zoneStore.moveComponent(
    lastMoveEvent.value.draggedContext.element.id,
    lastMoveEvent.value.draggedContext.futureIndex
  );
  lastMoveEvent.value = null;
};
</script>

<style scoped lang="scss">
@import "../../assets/styles/vars";

.subfields {
  padding-left: 1.5rem;
  cursor: pointer;
}

.subfieldAdd {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-left: 1.5rem;
  &:hover {
    background: $bg-hover-color;
  }
}

.dragging {
  border: 1px solid $bg-secondary-color;
}

.place-before::before,
.place-after::after {
  content: "";
  display: block;
  width: 60%;
  margin: auto;
  height: 4px;
  border-radius: 4px;
  background-color: $bg-secondary-color;
}
</style>
