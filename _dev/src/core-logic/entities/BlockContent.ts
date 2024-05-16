import { ComponentContent } from "./ComponentContent";
import { PrimitiveFieldContent } from "./PrimitiveFieldContent";
import { PrimitiveFieldType } from "./ElementType";
import { Repeater } from "./Repeater";

export type BlockContent = {
  id: string;
  block_id: string;
  fields: (
    | ComponentContent
    | PrimitiveFieldContent<PrimitiveFieldType>
    | Repeater<ComponentContent>
  )[];
};
