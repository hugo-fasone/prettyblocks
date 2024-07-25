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
        />
      </template>
    </draggable>
    <div class="blockAdd" @click="addNewBlock">
      <Icon name="PlusIcon" />
      Ajouter un block
    </div>
  </div>
</template>

<script setup lang="ts">
import { useZoneStore } from "../../core-logic/store/zoneStore";
import { storeToRefs } from "pinia";
import Element from "./Element.vue";
import { ref } from "vue";
import draggable from "vuedraggable";
import Icon from "../Icon.vue";
import emitter from "tiny-emitter/instance";

const zoneStore = useZoneStore();
const { content } = storeToRefs(zoneStore);
const lastMoveEvent = ref(null);

const handleMove = (moveEvent) => {
  lastMoveEvent.value = moveEvent;
  return false;
};

const handleDrop = () => {
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
  padding-right: 1rem;
  box-shadow: inset -0.5rem 0 0.5rem -0.3rem $bg-hover-color;
}

.blockAdd {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-left: 1.5rem;
  padding: 0.25rem 0.5rem;
  background: $bg-hover-color;
  color: $primary-color;
  border-radius: 0.5rem;
  box-shadow: $button-shadow;
  &:hover {
    background-color: $bg-secondary-color;
    color: $secondary-color;
  }
}
</style>
