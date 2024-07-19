<template>
  <div class="element">
    <div class="elementName">
      <span class="dragAndDropIcon" :draggable="true"
        ><Icon name="ChevronUpDownIcon" v-if="isMovable"
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
        <span
          v-if="(element as ComponentContent | PrimitiveFieldContent<PrimitiveFieldType>).optional"
          @click="toggleElement"
        >
          <Icon
            :name="(element as ComponentContent | PrimitiveFieldContent<PrimitiveFieldType>).hidden ? 'EyeSlashIcon' : 'EyeIcon'"
          />
        </span>
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
import {
  ComponentContent,
  FieldContent,
} from "../../core-logic/entities/ComponentContent";
import { useZoneStore } from "../../core-logic/store/zoneStore.js";
import { ref, nextTick } from "vue";
import Subfields from "./Subfields.vue";
import Icon from "../Icon.vue";
import { PrimitiveFieldType } from "../../core-logic/entities/ElementType";
import { PrimitiveFieldContent } from "../../core-logic/entities/PrimitiveFieldContent";

const { element, children, isDeletable, isMovable } = defineProps<{
  element: BlockContent | FieldContent;
  children: FieldContent[];
  isDeletable: boolean;
  isMovable: boolean;
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

const toggleElement = () => {
  zoneStore.toggleElement(element.id);
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
