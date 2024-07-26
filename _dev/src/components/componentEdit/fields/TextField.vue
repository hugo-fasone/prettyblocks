<template>
  <input
    ref="inputRef"
    type="text"
    :value="value.value"
    @change="onChange"
    @keyup.enter="onChange"
  />
</template>

<script setup lang="ts">
import { ref } from "vue";
import { PrimitiveTextType } from "../../../core-logic/entities/PrimitiveFieldContent";

const emit = defineEmits(["update:modelValue"]);
const { value } = defineProps<{ value: PrimitiveTextType }>();

const inputRef = ref(null);

function onChange(event) {
  emit("update:modelValue", { value: event.target.value });
  inputRef.value.blur();
}
</script>

<style scoped></style>
