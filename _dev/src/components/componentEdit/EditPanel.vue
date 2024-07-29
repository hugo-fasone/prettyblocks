<template>
  <div v-if="selectedElement" class="editPanel">
    <h2>{{ selectedElement.label }}</h2>
    <div
      v-if="
        selectedElement.type === 'component' || selectedElement.type === 'block'
      "
      class="editPanelContent"
    >
      <div class="subComponents" v-if="componentSubfields.length > 0">
        <h3>Sous-composants</h3>
        <EditField v-for="field in componentSubfields" :field="field" />
      </div>
      <div class="repeaters" v-if="repeaterSubfields.length > 0">
        <h3>Répéteurs</h3>
        <EditField v-for="field in repeaterSubfields" :field="field" />
      </div>
      <div class="primitiveFields" v-if="otherSubfields.length > 0">
        <h3>Champs</h3>
        <EditField v-for="field in otherSubfields" :field="field" />
      </div>
    </div>
    <div v-else-if="selectedElement.type === 'repeater'">
      <EditField v-for="field in selectedElement.sub_elements" :field="field" />
    </div>
    <EditField v-else :field="selectedElement" />
  </div>
</template>

<script setup lang="ts">
import { computed } from "vue";
import EditField from "./EditField.vue";
import { ComponentContent } from "../../core-logic/entities/ComponentContent";
import { useNavigationStore } from "../../core-logic/store/navigationStore";
import { storeToRefs } from "pinia";

const navigationStore = useNavigationStore();
const { selectedElement } = storeToRefs(navigationStore);

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
</script>

<style scoped lang="scss">
@import "../../assets/styles/vars";

.editPanel {
  padding-left: 1rem;
  box-shadow: inset 0.5rem 0 0.5rem -0.3rem $bg-hover-color;
  display: flex;
  flex-direction: column;
  h2 {
    font-size: 3rem;
    line-height: 3rem;
  }
  &Content {
    display: flex;
    flex-direction: column;
    gap: 2rem;
  }
}
</style>
