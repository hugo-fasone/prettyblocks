<template>
  <div class="block">
    <div class="blockName">
      <span class="dragAndDropIcon"><Icon name="ChevronUpDownIcon" /></span>
      <span class="blockDropdownArrow" @click="toggleCollapse">
        <Icon
          name="ChevronRightIcon"
          v-if="blockContent.fields.length > 0 && isCollapsed"
        />
        <Icon
          name="ChevronDownIcon"
          v-else-if="blockContent.fields.length > 0 && !isCollapsed"
        />
      </span>
      <span class="blockIcon"> </span>
      <span class="blockLabelInput" v-if="renameState">
        <input
          type="text"
          @change="renameBlock"
          @focusout="renameState = false"
          :value="blockContent.label"
          ref="inputRef"
        />
      </span>
      <span class="blockLabel" v-else>
        <span>{{ blockContent.label }}</span>
      </span>
      <span class="blockActions">
        <span @click="editBlockLabel"><Icon name="PencilIcon" /></span>
        <span @click="deleteBlock"><Icon name="TrashIcon" /></span>
      </span>
    </div>
    <Subfields :fields="blockContent.fields" v-if="!isCollapsed" :level="1" />
  </div>
</template>

<script setup lang="ts">
import { BlockContent } from "../../core-logic/entities/BlockContent";
import Subfields from "./Subfields.vue";
import { useZoneStore } from "../../core-logic/store/zoneStore";
import { ref, nextTick } from "vue";
import Icon from "../Icon.vue";

const { blockContent } = defineProps<{ blockContent: BlockContent }>();
const zoneStore = useZoneStore();
const renameState = ref(false);
const inputRef = ref(null);
const isCollapsed = ref(true);

const deleteBlock = () => {
  zoneStore.deleteBlockById(blockContent.id);
};

const editBlockLabel = async () => {
  renameState.value = true;
  nextTick(() => inputRef.value.focus());
};

const renameBlock = (event) => {
  zoneStore.renameBlock(blockContent.id, event.target.value);
  renameState.value = false;
};

const toggleCollapse = () => {
  isCollapsed.value = !isCollapsed.value;
};
</script>

<style scoped>
.blockName {
  display: flex;
  align-items: center;
}
.blockActions {
  display: flex;
  margin-left: auto;
}
</style>
