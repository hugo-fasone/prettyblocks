<template>
  <input
    class="dateInput"
    type="date"
    :value="value.value"
    @change="onChange"
    ref="inputRef"
  />
</template>

<script setup lang="ts">
import { ref } from "vue";
import { PrimitiveDateType } from "../../../core-logic/entities/PrimitiveFieldContent";

const emit = defineEmits(["update:modelValue"]);
const { value } = defineProps<{ value: PrimitiveDateType }>();
const inputRef = ref(null);

const onChange = (event) => {
  emit("update:modelValue", { value: event.target.value });
  inputRef.value.blur();
};
</script>

<style scoped>
.dateInput {
  display: block;
}
</style>
