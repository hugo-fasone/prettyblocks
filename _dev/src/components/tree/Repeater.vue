<template>
  <div>
    <div class="label">
      {{ repeater.label }}
    </div>
    <div class="subElements">
      <div v-for="subElement in repeater.sub_elements">
        <Component v-if="subElement.type === 'component'" />
        <PrimitiveField v-else />
      </div>
      <span>Ajouter un sous-élément</span>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Repeater } from "../../core-logic/entities/Repeater";
import { ComponentContent } from "../../core-logic/entities/ComponentContent";
import { PrimitiveFieldType } from "../../core-logic/entities/ElementType";

const { repeater } = defineProps<{
  repeater: Repeater<ComponentContent | PrimitiveFieldType>;
}>();
</script>

<style scoped></style>
