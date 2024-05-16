import { COMPONENT_TYPE, PrimitiveFieldType } from "./ElementType";

import { PrimitiveFieldContent } from "./PrimitiveFieldContent";
import { Repeater } from "./Repeater";

export type ComponentContent = {
  id: string;
  type: COMPONENT_TYPE;
  repeatable?: boolean;
  fields: (
    | ComponentContent
    | PrimitiveFieldContent<PrimitiveFieldType>
    | Repeater<ComponentContent>
  )[];
};
