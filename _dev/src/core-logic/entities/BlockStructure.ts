import { ComponentStructure } from "./ComponentStructure";
import { PrimitiveFieldStructure } from "./PrimitiveFieldStructure";
import { PrimitiveFieldType } from "./ElementType";

export type BlockStructure = {
  id: string;
  label: string;
  fields: Record<string, BlockFieldStructure>;
};

type BlockFieldStructure =
  | ComponentStructure
  | PrimitiveFieldStructure<PrimitiveFieldType>;
