import { BlockContent } from "../entities/BlockContent";
import { BlockStructure } from "../entities/BlockStructure";
import { ComponentContent } from "../entities/ComponentContent";
import { ComponentStructure } from "./../entities/ComponentStructure";
import { PrimitiveFieldContent } from "../entities/PrimitiveFieldContent";
import { PrimitiveFieldStructure } from "../entities/PrimitiveFieldStructure";
import { PrimitiveFieldType } from "../entities/ElementType";
import { Repeater } from "../entities/Repeater";
import { v4 as uuidv4 } from "uuid";

export const buildNewBlockContentFromBlockStructure = (
  blockStructure: BlockStructure
): BlockContent => {
  return {
    id: uuidv4() as string,
    block_id: blockStructure.id,
    fields: Object.values(blockStructure.fields).map(
      (
        field: ComponentStructure | PrimitiveFieldStructure<PrimitiveFieldType>
      ) => {
        if (field.type === "component")
          return buildNewComponentFromStructure(field);
        return buildNewPrimitiveFieldFromStructure(field);
      }
    ),
  };
};

const buildNewRepeaterFromStructure = (
  componentStructure: ComponentStructure
): Repeater<ComponentContent> => {
  return {
    id: uuidv4(),
    component_id: componentStructure.id,
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
): ComponentContent | Repeater<ComponentContent> => {
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
  };
};
