import { PrimitiveFieldContentMap } from "./PrimitiveFieldContent";
import { PrimitiveFieldType } from "./ElementType";

export type PrimitiveFieldStructure<T extends PrimitiveFieldType> = {
  label: string;
  type: T;
  default: PrimitiveFieldContentMap[T];
  repeatable?: boolean;
  optional?: boolean;
};
