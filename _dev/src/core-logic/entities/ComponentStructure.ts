import { PrimitiveFieldStructure } from "./PrimitiveFieldStructure";
import { PrimitiveFieldType } from "./PrimitiveFieldType";
type COMPONENT_TYPE = "component";

export type ComponentStructure = {
  id: string;
  type: COMPONENT_TYPE;
  label: string;
  fields: Record<string, ComponentFieldStructure>;
};

type ComponentFieldStructure =
  | ComponentStructure
  | PrimitiveFieldStructure<PrimitiveFieldType>;
