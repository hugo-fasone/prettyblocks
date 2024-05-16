import { PrimitiveFieldContentData } from "./PrimitiveFieldContent";
import { PrimitiveFieldType } from "./ElementType";

export type PrimitiveFieldStructure<T extends PrimitiveFieldType> = {
  label: string;
  type: T;
  default: PrimitiveFieldContentData;
  repeatable?: boolean;
};
