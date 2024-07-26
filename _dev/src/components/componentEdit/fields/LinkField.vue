<template>
  <div class="linkInput">
    <span> Label </span>
    <input
      ref="labelRef"
      type="text"
      :value="value.label"
      @change="onChange"
      @keyup.enter="onChange"
    />
    <span> Url </span>
    <input
      ref="hrefRef"
      type="text"
      :value="value.href"
      @change="onChange"
      @keyup.enter="onChange"
    />
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { PrimitiveLinkType } from "../../../core-logic/entities/PrimitiveFieldContent";

const emit = defineEmits(["update:modelValue"]);
const { value } = defineProps<{ value: PrimitiveLinkType }>();

const labelRef = ref(null);
const hrefRef = ref(null);

const onChange = () => {
  emit("update:modelValue", {
    label: labelRef.value.value,
    href: hrefRef.value.value,
  });
  hrefRef.value.blur();
  labelRef.value.blur();
};
</script>

<style scoped lang="scss">
.linkInput {
  display: grid;
  grid-template-columns: 5rem 1fr;
  align-items: center;
  gap: 0.5rem;
}
</style>
