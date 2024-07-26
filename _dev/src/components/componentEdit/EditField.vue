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
import EditPrimitiveField from "./EditPrimitiveField.vue";
import emitter from "tiny-emitter/instance";

const { field } = defineProps<{
  field: FieldContent;
}>();

const switchComponent = () => {
  emitter.emit("editComponent", field);
};
</script>

<style scoped lang="scss">
@import "../../assets/styles/vars";

.componentLink {
  background-color: $bg-hover-color;
}
</style>
