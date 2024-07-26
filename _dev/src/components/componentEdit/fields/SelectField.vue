<template>
  <select :value="value.value" @input="onChange" class="select">
    <option v-for="option in value.options" :value="option.value">
      {{ option.label }}
    </option>
  </select>
</template>

<script setup lang="ts">
import { PrimitiveSelectType } from "../../../core-logic/entities/PrimitiveFieldContent";

const emit = defineEmits(["update:modelValue"]);
const { value } = defineProps<{ value: PrimitiveSelectType }>();

function onChange(event) {
  emit("update:modelValue", {
    value: event.target.value,
    options: value.options,
  });
}
</script>

<style scoped>
.select {
  display: block;
}
</style>
