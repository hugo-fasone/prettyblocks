<template>
  <div class="tree">
    <draggable
      :list="content"
      group="blocks"
      item-key="id"
      :move="handleMove"
      @end="handleDrop"
    >
      <template #item="{ element }">
        <Element
          :element="element"
          :level="0"
          :children="element.fields"
          :isDeletable="true"
          :isMovable="true"
          :isDuplicable="true"
          :move="handleMove"
          @end="handleDrop"
          class="tree-element"
        />
      </template>
    </draggable>
    <div class="blockAdd" @click="addNewBlock">
      <Icon name="PlusIcon" />
      Ajouter un bloc
    </div>
  </div>
</template>

<script setup lang="ts">
import {useZoneStore} from "../../core-logic/store/zoneStore";
import {storeToRefs} from "pinia";
import Element from "./Element.vue";
import {ref} from "vue";
import draggable from "vuedraggable";
import Icon from "../Icon.vue";
import emitter from "tiny-emitter/instance";

const zoneStore = useZoneStore();
const { content } = storeToRefs(zoneStore);
const lastMoveEvent = ref(null);

const handleMove = (moveEvent) => {
  lastMoveEvent.value = moveEvent;
  document
    .querySelectorAll(".tree-element")
    .forEach((treeElement) =>
      treeElement.classList.remove("place-after", "place-before")
    );
  moveEvent.related.classList.add(
    moveEvent.willInsertAfter ? "place-after" : "place-before"
  );
  return false;
};

const handleDrop = () => {
  document
    .querySelectorAll(".tree-element")
    .forEach((treeElement) =>
      treeElement.classList.remove("place-after", "place-before")
    );
  if (!lastMoveEvent.value) return;
  zoneStore.moveBlock(
    lastMoveEvent.value.draggedContext.element.id,
    lastMoveEvent.value.draggedContext.futureIndex
  );
  lastMoveEvent.value = null;
};

const addNewBlock = () => {
  emitter.emit("toggleAddBlockModal");
};
</script>

<style scoped lang="scss">
@import "../../assets/styles/vars";

.tree {
  min-width: 25rem;
  box-shadow: inset -0.5rem 0 0.5rem -0.3rem $bg-hover-color;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.blockAdd {
  margin: 0 1rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.75rem 1rem;
  background: $bg-hover-color;
  color: $primary-color;
  border-radius: 0.5rem;
  &:hover {
    background-color: $bg-secondary-color;
    color: $secondary-color;
  }
}

.dragging {
  background-color: $bg-hover-color;
}

.place-before::before,
.place-after::after {
  content: "";
  display: block;
  width: 100%;
  margin: auto;
  height: 2.5rem;
  border: 1px dashed $bg-secondary-color;
  border-radius: 0.5rem;
}
</style>
