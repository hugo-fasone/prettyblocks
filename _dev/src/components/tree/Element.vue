<template>
  <div class="element">
    <div
      class="elementName"
      :class="(element as FieldContent).hidden ? 'hidden' : ''"
    >
      <span class="dragAndDropIcon" :draggable="true"
        ><Icon name="ChevronUpDownIcon" v-if="isMovable"
      /></span>
      <span class="elementDropdownArrow" @click="toggleCollapse">
        <Icon
          name="ChevronRightIcon"
          v-if="
            (element.type === 'repeater' || children.length > 0) && isCollapsed
          "
        />
        <Icon
          name="ChevronDownIcon"
          v-else-if="
            (element.type === 'repeater' || children.length > 0) && !isCollapsed
          "
        />
      </span>
      <span class="elementIcon"></span>
      <span class="elementLabelInput" v-if="renameState">
        <input
          type="text"
          @change="renameElement"
          @focusout="renameState = false"
          @keyup.enter="renameElement"
          :value="element.label"
          ref="inputRef"
          class="labelInput"
        />
      </span>
      <span class="elementLabel" v-else>
        <span @click="selectElement" @dblclick="editElementLabel">{{
          element.label
        }}</span>
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
import emitter from "tiny-emitter/instance";

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
  renameState.value = false;
};

const toggleCollapse = () => {
  isCollapsed.value = !isCollapsed.value;
};

const toggleElement = () => {
  zoneStore.toggleElement(element.id);
};

const selectElement = () => {
  emitter.emit("editComponent", element);
};
</script>

<style scoped lang="scss">
@import "../../assets/styles/vars";

.element {
  color: $primary-color;
}
.elementName {
  display: flex;
  align-items: center;
  padding: 0.25rem;
  border-radius: 0.5rem;
  &:hover {
    background-color: $bg-hover-color;
    > .elementActions {
      display: flex;
    }
    > .dragAndDropIcon {
      visibility: visible;
    }
  }
}

.hidden {
  color: $disabled-color;
}

.elementLabel {
  cursor: pointer;
}

.elementDropdownArrow {
  cursor: pointer;
}

.elementActions {
  display: none;
  margin-left: auto;
  gap: 0.5rem;
  span {
    cursor: pointer;
  }
}

.elementDropdownArrow,
.dragAndDropIcon {
  width: 1.5rem;
}

.dragAndDropIcon {
  visibility: hidden;
  cursor: move;
}

.elementLabelInput {
  flex: 1;
}

.labelInput {
  padding: 0.25rem 0.5rem;
  margin-right: 0.5rem;
  width: 100%;
  border-radius: 0.5rem;
  &:focus {
    border: 2px solid $primary-color;
    box-shadow: none;
  }
}
</style>
