import type { BlockContent } from "../entities/BlockContent";
import type { BlockStructure } from "../entities/BlockStructure";
import type { ComponentContent } from "../entities/ComponentContent";
import type { ComponentStructure } from "./../entities/ComponentStructure";
import type { PrimitiveFieldContent } from "../entities/PrimitiveFieldContent";
import type { PrimitiveFieldStructure } from "../entities/PrimitiveFieldStructure";
import { PrimitiveFieldType } from "../entities/ElementType";
import type { Repeater } from "../entities/Repeater";
import { v4 as uuidv4 } from "uuid";

export const buildNewBlockContentFromBlockStructure = (
  blockStructure: BlockStructure
): BlockContent => {
  return {
    id: uuidv4() as string,
    block_id: blockStructure.id,
    label: blockStructure.label,
    fields: Object.values(blockStructure.fields).map(
      (
        field: ComponentStructure | PrimitiveFieldStructure<PrimitiveFieldType>
      ) => {
        if (field.repeatable) return buildNewRepeaterFromStructure(field);
        if (field.type === "component")
          return buildNewSingleComponentFromStructure(field);
        return buildNewPrimitiveFieldFromStructure(field);
      }
    ),
  };
};

const buildNewRepeaterFromStructure = (
  componentStructure:
    | ComponentStructure
    | PrimitiveFieldStructure<PrimitiveFieldType>
): Repeater<ComponentContent | PrimitiveFieldType> => {
  return {
    id: uuidv4(),
    component_id:
      componentStructure.type === "component"
        ? componentStructure.id
        : componentStructure.type,
    type: "repeater",
    label: componentStructure.label,
    sub_elements: [],
  };
};

export const buildNewSingleComponentFromStructure = (
  componentStructure: ComponentStructure
): ComponentContent => {
  return {
    id: uuidv4(),
    component_id: componentStructure.id,
    type: componentStructure.type,
    label: componentStructure.label,
    optional: componentStructure.optional,
    fields: Object.values(componentStructure.fields).map((field) => {
      if (field.type === "component") {
        return buildNewComponentFromStructure(field);
      }
      return buildNewPrimitiveFieldFromStructure(field);
    }),
  };
};

export const buildNewComponentFromStructure = (
  componentStructure: ComponentStructure
): ComponentContent | Repeater<ComponentContent | PrimitiveFieldType> => {
  return componentStructure.repeatable
    ? buildNewRepeaterFromStructure(componentStructure)
    : buildNewSingleComponentFromStructure(componentStructure);
};

export const buildNewPrimitiveFieldFromStructure = (
  primitiveFieldStructure: PrimitiveFieldStructure<PrimitiveFieldType>
): PrimitiveFieldContent<PrimitiveFieldType> => {
  return {
    id: uuidv4(),
    type: primitiveFieldStructure.type,
    label: primitiveFieldStructure.label,
    content: primitiveFieldStructure.default,
    optional: primitiveFieldStructure.optional,
  };
};
