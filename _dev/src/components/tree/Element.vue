<template>
  <div class="element">
    <div class="elementName">
      <span class="dragAndDropIcon"
        ><Icon name="ChevronUpDownIcon" v-if="isDeletable"
      /></span>
      <span class="elementDropdownArrow" @click="toggleCollapse">
        <Icon
          name="ChevronRightIcon"
          v-if="children.length > 0 && isCollapsed"
        />
        <Icon
          name="ChevronDownIcon"
          v-else-if="children.length > 0 && !isCollapsed"
        />
      </span>
      <span class="elementIcon"></span>
      <span class="elementLabelInput" v-if="renameState">
        <input
          type="text"
          @change="renameElement"
          @focusout="renameState = false"
          :value="element.label"
          ref="inputRef"
        />
      </span>
      <span class="elementLabel" v-else>
        <span>{{ element.label }}</span>
      </span>
      <span class="elementActions">
        <span @click="editElementLabel"><Icon name="PencilIcon" /></span>
        <span v-if="isDeletable" @click="deleteElement"
          ><Icon name="TrashIcon"
        /></span>
      </span>
    </div>
    <Subfields
      v-if="!isCollapsed"
      :fields="children"
      :parentElement="element"
    />
  </div>
</template>

<script setup lang="ts">
import { BlockContent } from "../../core-logic/entities/BlockContent";
import { FieldContent } from "../../core-logic/entities/ComponentContent";
import { useZoneStore } from "../../core-logic/store/zoneStore.js";
import { ref, nextTick } from "vue";
import Subfields from "./Subfields.vue";
import Icon from "../Icon.vue";

const { element, children, isDeletable } = defineProps<{
  element: BlockContent | FieldContent;
  children: FieldContent[];
  isDeletable: boolean;
}>();

const zoneStore = useZoneStore();
const renameState = ref(false);
const inputRef = ref(null);
const isCollapsed = ref(true);

const deleteMap = {
  block: zoneStore.deleteBlockById,
  component: zoneStore.deleteComponentById,
};
const deleteElement = () => {
  if (isDeletable) {
    deleteMap[element.type](element.id);
  }
};

const editElementLabel = async () => {
  renameState.value = true;
  nextTick(() => inputRef.value.focus());
};

const renameElement = (event) => {
  zoneStore.renameElement(element.id, event.target.value);
};

const toggleCollapse = () => {
  isCollapsed.value = !isCollapsed.value;
};
</script>

<style scoped>
.elementName {
  display: flex;
  align-items: center;
}
.elementActions {
  display: flex;
  margin-left: auto;
}
.elementDropdownArrow,
.dragAndDropIcon {
  width: 1.5rem;
}
</style>
