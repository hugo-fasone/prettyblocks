// Add new PrimitiveFieldContent here
type PrimitiveTextType = {
  value: string;
};

type PrimitiveNumberType = {
  value: number;
};

// Add mapping to your new primitive field content here
export type PrimitiveFieldContentData = PrimitiveTextType | PrimitiveNumberType;

export type PrimitiveFieldContent = {
  id: string;
  content: PrimitiveFieldContentData;
};
