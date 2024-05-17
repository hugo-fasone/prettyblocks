import { PrimitiveFieldType } from "./ElementType";

// Add new PrimitiveFieldContent here
export type PrimitiveTextType = {
  value: string;
};

export type PrimitiveNumberType = {
  value: number;
};

// Add mapping to your new primitive field content here
export interface PrimitiveFieldContentMap {
  [PrimitiveFieldType.TEXT]: PrimitiveTextType;
  [PrimitiveFieldType.NUMBER]: PrimitiveNumberType;
}

export type PrimitiveFieldContent<T extends PrimitiveFieldType> = {
  id: string;
  type: PrimitiveFieldType;
  label: string;
  content: PrimitiveFieldContentMap[T];
};
