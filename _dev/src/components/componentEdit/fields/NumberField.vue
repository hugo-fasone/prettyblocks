<template>
  <input
    ref="inputRef"
    type="number"
    :value="value.value"
    @change="onChange"
    @keyup.enter="validateAndChange"
  />
</template>

<script setup lang="ts">
import { ref } from "vue";
import { PrimitiveNumberType } from "../../../core-logic/entities/PrimitiveFieldContent";

const emit = defineEmits(["update:modelValue"]);
const { value } = defineProps<{ value: PrimitiveNumberType }>();

const inputRef = ref(null);

const validateAndChange = (event) => {
  inputRef.value.blur();
  onChange(event);
};
const onChange = (event) => {
  emit("update:modelValue", { value: Number(event.target.value) });
};
</script>

<style scoped></style>
