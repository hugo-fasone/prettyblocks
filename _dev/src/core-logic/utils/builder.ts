import { ComponentStructure } from "./../entities/ComponentStructure";
import { BlockContent } from "../entities/BlockContent";
import { BlockStructure } from "../entities/BlockStructure";
import { COMPONENT_TYPE } from "./../entities/ElementType";
import { ComponentContent } from "../entities/ComponentContent";
import { ComponentStructure } from "../entities/ComponentStructure";
import { PrimitiveFieldContent } from "../entities/PrimitiveFieldContent";
import { PrimitiveFieldStructure } from "../entities/PrimitiveFieldStructure";
import { PrimitiveFieldType } from "../entities/ElementType";
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

export const buildNewComponentFromStructure = (
  componentStructure: ComponentStructure
): ComponentContent => {
  return {};
};

const buildNewRepeatableComponentFromStructure = (
  componentStructure: ComponentStructure
): ComponentContent => {
  return {};
};

export const buildNewPrimitiveFieldFromStructure = (
  primitiveFieldStructure: PrimitiveFieldStructure<PrimitiveFieldType>
): PrimitiveFieldContent<PrimitiveFieldType> => {
  return {};
};
