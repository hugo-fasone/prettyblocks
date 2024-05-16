import { PrimitiveFieldContentData } from "./PrimitiveFieldContent";
import { PrimitiveFieldType } from "./PrimitiveFieldType";

export type PrimitiveFieldStructure = {
  label: string;
  type: PrimitiveFieldType;
  default: PrimitiveFieldContentData;
};
