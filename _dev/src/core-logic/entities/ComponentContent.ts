import { COMPONENT_TYPE, PrimitiveFieldType } from "./ElementType";

import { PrimitiveFieldContent } from "./PrimitiveFieldContent";
import { Repeater } from "./Repeater";

export type ComponentContent = {
  id: string;
  component_id: string;
  type: COMPONENT_TYPE;
  label: string;
  fields: (
    | ComponentContent
    | PrimitiveFieldContent<PrimitiveFieldType>
    | Repeater<ComponentContent>
  )[];
};
