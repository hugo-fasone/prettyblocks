<template>
  <div v-if="currentComponent" class="editPanel">
    <h2>{{ currentComponent.label }}</h2>
    <div
      v-if="
        currentComponent.type === 'component' ||
        currentComponent.type === 'block'
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
    <div v-else-if="currentComponent.type === 'repeater'">
      <EditField
        v-for="field in currentComponent.sub_elements"
        :field="field"
      />
    </div>
    <EditField v-else :field="currentComponent" />
  </div>
</template>

<script setup lang="ts">
import emitter from "tiny-emitter/instance";
import { computed, ref } from "vue";
import EditField from "./EditField.vue";
import {
  ComponentContent,
  FieldContent,
} from "../../core-logic/entities/ComponentContent";
import { BlockContent } from "../../core-logic/entities/BlockContent";

const currentComponent = ref<FieldContent | BlockContent>(null);

emitter.on("editComponent", (component: FieldContent | BlockContent) => {
  currentComponent.value = component;
});

const componentSubfields = computed(() =>
  (currentComponent.value as ComponentContent).fields.filter(
    (field) => field.type === "component"
  )
);

const repeaterSubfields = computed(() =>
  (currentComponent.value as ComponentContent).fields.filter(
    (field) => field.type === "repeater"
  )
);
const otherSubfields = computed(() =>
  (currentComponent.value as ComponentContent).fields.filter(
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
