import { PrimitiveFieldType } from "./ElementType";

// Add new PrimitiveFieldContent here
type PrimitiveTextType = {
  value: string;
};

type PrimitiveNumberType = {
  value: number;
};

// Add mapping to your new primitive field content here
export type PrimitiveFieldContentData = PrimitiveTextType | PrimitiveNumberType;

export interface PrimitiveFieldContentMap {
  [PrimitiveFieldType.TEXT]: PrimitiveTextType;
  [PrimitiveFieldType.NUMBER]: PrimitiveNumberType;
}

export type PrimitiveFieldContent<T extends PrimitiveFieldType> = {
  id: string;
  content: PrimitiveFieldContentMap[T];
};
