<template>
  <div v-if="selectedElement" class="editPanel">
    <div class="title">
      <h2>Edition</h2>
      <h3>{{ selectedElement.label }}</h3>
    </div>
    <div
      v-if="
        selectedElement.type === 'component' || selectedElement.type === 'block'
      "
      class="editPanelContent"
    >
      <div
        class="contentCategory subComponents"
        v-if="componentSubfields.length > 0"
      >
        <h3>Sous-composants</h3>
        <EditField v-for="field in componentSubfields" :field="field" />
      </div>
      <div
        class="contentCategory repeaters"
        v-if="repeaterSubfields.length > 0"
      >
        <h3>Répéteurs</h3>
        <EditField v-for="field in repeaterSubfields" :field="field" />
      </div>
      <div
        class="contentCategory primitiveFields"
        v-if="otherSubfields.length > 0"
      >
        <h3>Champs</h3>
        <EditField v-for="field in otherSubfields" :field="field" />
      </div>
    </div>
    <EditField v-else :field="selectedElement" />
  </div>
</template>

<script setup lang="ts">
import { computed } from "vue";
import EditField from "./EditField.vue";
import {
  ComponentContent,
  FieldContent,
} from "../../core-logic/entities/ComponentContent";
import { useNavigationStore } from "../../core-logic/store/navigationStore";
import { storeToRefs } from "pinia";
import { findComponentBlock } from "../../core-logic/utils/finder";
import { Repeater } from "../../core-logic/entities/Repeater";
import { useZoneStore } from "../../core-logic/store/zoneStore";
import Icon from "../Icon.vue";

const navigationStore = useNavigationStore();
const { selectedElement } = storeToRefs(navigationStore);
const zoneStore = useZoneStore();

const componentSubfields = computed(() =>
  (selectedElement.value as ComponentContent).fields.filter(
    (field) => field.type === "component"
  )
);

const repeaterSubfields = computed(() =>
  (selectedElement.value as ComponentContent).fields.filter(
    (field) => field.type === "repeater"
  )
);
const otherSubfields = computed(() =>
  (selectedElement.value as ComponentContent).fields.filter(
    (field) => field.type !== "component" && field.type !== "repeater"
  )
);

const addNewElement = () => {
  const blockId = findComponentBlock(
    zoneStore.content,
    selectedElement.value.id
  ).id;
  const componentId = (selectedElement.value as Repeater<FieldContent>)
    .component_id;
  zoneStore.addComponent(blockId, selectedElement.value.id, componentId);
};
</script>

<style scoped lang="scss">
@import "../../assets/styles/vars";

.editPanel {
  padding: 1rem;
  box-shadow: inset 0.5rem 0 0.5rem -0.3rem $bg-hover-color;
  display: flex;
  flex-direction: column;
  display: flex;
  flex-direction: column;
  gap: 1rem;
  max-height: 100%;
  .title {
    padding-bottom: 1rem;
    border-bottom: 1px solid $bg-hover-color;
  }
  h2 {
    font-size: 2rem;
    line-height: 2rem;
  }
  &Content {
    display: flex;
    flex-direction: column;
    gap: 2rem;
    overflow-y: auto;
    overflow-x: hidden;
  }
  .contentCategory {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }
  .subfieldAdd {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    background: $bg-hover-color;
    color: $primary-color;
    border-radius: 0.5rem;
    cursor: pointer;
    &:hover {
      background-color: $bg-secondary-color;
      color: $secondary-color;
    }
  }
}
</style>
