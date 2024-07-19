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

<style scoped>
.tree {
  width: 20rem;
}

.blockAdd {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}
</style>
