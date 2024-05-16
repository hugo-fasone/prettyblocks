import { ComponentStructure } from "./ComponentStructure";
import { PrimitiveFieldStructure } from "./PrimitiveFieldStructure";

export type BlockStructure = {
  id: string;
  label: string;
  fields: Record<string, BlockFieldStructure>;
};

type BlockFieldStructure = ComponentStructure | PrimitiveFieldStructure;
