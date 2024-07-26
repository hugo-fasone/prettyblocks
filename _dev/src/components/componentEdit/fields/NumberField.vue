<template>
  <input
    ref="inputRef"
    type="number"
    :value="value"
    @change="onChange"
    @keyup.enter="onChange"
  />
</template>

<script setup lang="ts">
import { ref } from "vue";

const emit = defineEmits(["update:modelValue"]);
const { value } = defineProps<{ value: string }>();

const inputRef = ref(null);

function onChange(event) {
  emit("update:modelValue", { value: event.target.value });
  inputRef.value.blur();
}
</script>

<style scoped></style>
