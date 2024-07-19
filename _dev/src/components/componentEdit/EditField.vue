<template>
  <div>
    <div @click="switchComponent">
      {{ field.label }}
    </div>
    <input
      v-if="field.type === PrimitiveFieldType.TEXT"
      type="text"
      :value="(field.content as PrimitiveFieldContentMap[PrimitiveFieldType.TEXT]).value"
      @change="editField"
    />
  </div>
</template>

<script setup lang="ts">
import { FieldContent } from "../../core-logic/entities/ComponentContent.js";
import emitter from "tiny-emitter/instance";
import { PrimitiveFieldContentMap } from "../../core-logic/entities/PrimitiveFieldContent.js";
import { PrimitiveFieldType } from "../../core-logic/entities/ElementType.js";
import { useZoneStore } from "../../core-logic/store/zoneStore.js";

const { field } = defineProps<{
  field: FieldContent;
}>();

const zoneStore = useZoneStore();

const switchComponent = () => {
  if (field.type === "component" || field.type === "repeater")
    emitter.emit("editComponent", field);
};

const editField = (event) => {
  console.log(event.target.value);
  zoneStore.editPrimitiveField(field.id, { value: event.target.value });
};
</script>

<style scoped></style>
