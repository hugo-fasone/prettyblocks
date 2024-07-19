<template>
  <div v-if="currentComponent">
    <h2>Editing {{ currentComponent.label }}</h2>
    <div
      v-if="
        currentComponent.type === 'component' ||
        currentComponent.type === 'block'
      "
    >
      <EditField v-for="field in currentComponent.fields" :field="field" />
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
import { ref } from "vue";
import EditField from "./EditField.vue";
import { FieldContent } from "../../core-logic/entities/ComponentContent";
import { BlockContent } from "../../core-logic/entities/BlockContent";

const currentComponent = ref<FieldContent | BlockContent>(null);

emitter.on("editComponent", (component: FieldContent | BlockContent) => {
  currentComponent.value = component;
});
</script>

<style scoped></style>
