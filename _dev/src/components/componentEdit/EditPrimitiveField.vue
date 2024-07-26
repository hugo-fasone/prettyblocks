<template>
  <component
    :is="componentMap[field.type]"
    :value="(field.content as PrimitiveFieldContentMap[PrimitiveFieldType.TEXT])"
    @update:modelValue="editField"
  />
</template>

<script setup lang="ts">
import { PrimitiveFieldType } from "../../core-logic/entities/ElementType";
import {
  PrimitiveFieldContent,
  PrimitiveFieldContentMap,
} from "../../core-logic/entities/PrimitiveFieldContent";
import TextField from "./fields/TextField.vue";
import NumberField from "./fields/NumberField.vue";
import RangeField from "./fields/RangeField.vue";
import WysiwygField from "./fields/WysiwygField.vue";
import { useZoneStore } from "../../core-logic/store/zoneStore";

const { field } = defineProps<{
  field: PrimitiveFieldContent<PrimitiveFieldType>;
}>();
const zoneStore = useZoneStore();

const editField = (newContent: PrimitiveFieldContent<PrimitiveFieldType>) => {
  zoneStore.editPrimitiveField(field.id, newContent);
};

type ComponentMap<T extends PrimitiveFieldType> = {
  [K in T]: PrimitiveFieldContentMap[T];
};
const componentMap: ComponentMap<PrimitiveFieldType> = {
  [PrimitiveFieldType.TEXT]: TextField,
  [PrimitiveFieldType.NUMBER]: NumberField,
  [PrimitiveFieldType.RANGE]: RangeField,
  [PrimitiveFieldType.WYSIWYG]: WysiwygField,
};
</script>

<style scoped lang="scss"></style>
