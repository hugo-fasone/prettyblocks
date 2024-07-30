<template>
  <div>
    <div
      v-if="field.type === 'component' || field.type === 'repeater'"
      @click="switchComponent"
      class="componentLink"
    >
      {{ field.label }}
    </div>
    <div v-else>
      {{ field.label }}
      <EditPrimitiveField :field="field" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { FieldContent } from "../../core-logic/entities/ComponentContent.js";
import { useNavigationStore } from "../../core-logic/store/navigationStore.js";
import EditPrimitiveField from "./EditPrimitiveField.vue";

const { field } = defineProps<{
  field: FieldContent;
}>();

const switchComponent = () => {
  useNavigationStore().selectElement(field);
};
</script>

<style scoped lang="scss">
@import "../../assets/styles/vars";

.componentLink {
  background-color: $bg-hover-color;
  color: $primary-color;
  border-radius: 0.5rem;
  padding: 0.75rem 1rem;
  cursor: pointer;
}
</style>
